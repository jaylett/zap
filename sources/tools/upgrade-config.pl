#!/usr/bin/perl
# $Id: upgrade-config.pl,v 1.1 2002/09/09 20:21:40 james Exp $
#
# upgrade-config.pl
# Author: James Aylett
# (c) Zap Developers 2002
#
# FIXME: in filtered files, should print out a line at the start saying what we've done.
# Not all files can accept lines starting '#' as comments, so we need to avoid putting
# things like '&' in them as well. Oh, and some have comments starting '|'. Or maybe that's
# all of them?

require 5.001;
use strict;
use Getopt::Long;
use Pod::Usage;

# These two MUST NOT contain ampersands, because they get embedded in upgraded files, which
# often identify non-comment lines as those containing an ampersand-prefixed hex number.
my ($progname, $progversion) = ("upgrade-config.pl", "1.0");

my ($verbose, $help, $man) = ('', 0, 0);

Getopt::Long::Configure("bundling");

GetOptions('help|?' => \$help,
           'man' => \$man,
           'verbose' => \$verbose) or
pod2usage(2);
pod2usage(1) if $help;
pod2usage(-exitstatus => 0, -verbose => 2) if $man;

my ($currentdir, $upgradedir);

my ($dirsep, $baksuffix) = ('/', '.bak');
my ($extfff, $extffd, $extff9, $extfeb) = (',fff', ',ffd', ',ff9', ',feb');

$currentdir = shift or die "You must give the location of the existing !ZapUser.\n";
$upgradedir = shift or die "You must give the location of the !ZapUser you want to upgrade to.\n";

# Update structure. No backups here.
#
# (1) Update !Run, !Boot, !Sprites*, !Help
# (2) Ensure all appropriate directories exist. Generated, Inserts, Scripts, Templates, Tiles.
# (3) Update Config.!ReadMe, Generated.!ReadMe

upgrade_trying("update !ZapUser core files");
copy('!Boot', $extfeb);
copy('!Run', $extfeb);
copy('!Sprites', $extff9);
copy('!Sprites22', $extff9);
upgrade_done();

upgrade_trying("update !ZapUser structure");
ensuredir('Generated');
ensuredir('Inserts');
ensuredir('Scripts');
ensuredir('Templates');
ensuredir('Tiles');
ensuredir('Config') or die "Config directory does not exist in current !ZapUser: this is not a recent enough installation for me to upgrade.\n";
upgrade_done();

upgrade_trying("update structure help files");
copy('!Help', $extfff);
copy("Config$dirsep!ReadMe", $extfff);
copy("Generated$dirsep!ReadMe", $extfff);
upgrade_done();

# For all modified files, backup first.
#
# (1) Config.!ZapBoot, Config.!ZapRun, Config.!ZapBooted (file claims and template set).
#     Config.Country (only if it doesn't exist).
# (2) Config.Settings (&322, &323).
# (3) Config.TMFs: remove non-core unless they've changed from defaults (HOW?).
# (4) Config.Keys: move to directory, remove duplicate maps?, &400->&800.
# (5) Config.Menus: move to directory as backup, copy in sourced and generated versions.
# (6) Config.FileID*.

upgrade_trying("update system, filetype and path setup");
ensurefile("Config${dirsep}Country", $extfeb);
ensurefile("Config${dirsep}!ZapBooted", $extfeb);

# FIXME: should really upgrade while keeping template (if possible) and filetype claims
backupfile("$currentdir${dirsep}Config${dirsep}!ZapBoot", $extfeb);
backupfile("$currentdir${dirsep}Config${dirsep}!ZapRun", $extfeb);
ensurefile("Config${dirsep}!ZapBoot", $extfeb);
ensurefile("Config${dirsep}!ZapRun", $extfeb);
upgrade_done("NOT upgraded: you must merge in changes yourself");

sub getsettingslines($\@) {
  my ($line, $optsref) = @_;
  my @opts = @$optsref;
  my $opt;
  if ($line =~ m/^.*[[:space:]](&[[:digit:]]*)[[:space:]].*$/) {
    foreach $opt (@opts) {
      if ($opt eq $1) {
#        print "($opt==$1)";
        return 1;
      }
    }
  }
  return 0;
}

# Note: we must pass the array at the end in by reference, because we want to
# modify it in one call but use it in another (if we find a variable already
# being output, kill it in the array so we don't do it again later).
sub ensuresettingslines($$\@) {
  my ($ctx, $line, $optsref) = @_;
#  print "ensuresettingslines($ctx, '$line'): ";
  if ($ctx==0) {
    # START
    return "Upgraded by $progname v$progversion.";
  } elsif ($ctx==1) {
    # normal line
    if ($line =~ m/^.*[[:space:]](&[[:digit:]]*)[[:space:]].*$/) {
      my $setvar = $1; # the number of the variable on this line
      my $linesref = $$optsref[0];
      my $i=0;
      while ($i < scalar @$linesref) {
        if ($$linesref[$i] =~ m/^.*[[:space:]](&[[:digit:]]*)[[:space:]].*$/) {
          if ($1 eq $setvar) {
            splice @$linesref, $i, 1;
            $i--; # because we've spliced it out of existence
          }
        }
        ++$i;
      }
    }
    return $line;
  } elsif ($ctx==2) {
    # END
    my $linesref = $$optsref[0];
    my ($l, $n);
    $n = '';
    foreach $l (@$linesref) {
      $n = "$n$l\n";
    }
    chomp $n;
    return $n;
  }
  return $line;
}

upgrade_trying("update Config.Settings");
upgrade_point("backing up old file");
my $bakname = backupfile("$currentdir${dirsep}Config${dirsep}Settings", $extfff);
if ($bakname ne '') {
  upgrade_point_done();
  upgrade_point("finding new options");
  my @changelines = &getlines("$upgradedir${dirsep}Config${dirsep}Settings$extfff", \&getsettingslines, "&322", "&323");
  upgrade_point_done();
  if (scalar @changelines > 0) {
    upgrade_point("merging options");
    &filterfile($bakname, "$currentdir${dirsep}Config${dirsep}Settings$extfff", \&ensuresettingslines, \@changelines);
    upgrade_point_done();
  }
} else {
  upgrade_point_failed();
  exit 1;
}
upgrade_done();

upgrade_trying("update Config.TMFs");
if (ensuredir("Config${dirsep}TMFs")) {
  copydircontents("Config${dirsep}TMFs");
} else {
  # FIXME: for v1.45, should in theory get rid of TMFs that should no
  # longer be here. However figuring out if they've been changed is
  # difficult, and from v1.46 or soon thereafter TMFs will fall back
  # properly from user to mode settings, at which point it largely
  # doesn't matter. (Although at that point we should prompt people to
  # get rid of unnecessary override, which we could actually check directly.)
  copydircontents("Config${dirsep}TMFs");
}
upgrade_done();

upgrade_trying("update Config.Keys");
if (-d "$currentdir${dirsep}Config{$dirsep}Keys") {
  # FIXME: should try to upgrade
  upgrade_done("NOT upgraded: you must merge in changes yourself");
} else {
  my $bakname = '';
  if (-f "$currentdir${dirsep}Config${dirsep}Keys$extfff") {
    upgrade_point("backing up old Keys file");
    $bakname = backupfile("$currentdir${dirsep}Config${dirsep}Keys", $extfff);
    if ($bakname) {
      upgrade_point_done();
    } else {
      upgrade_point_failed();
      exit 1;
    }
  }
  ensuredir("Config${dirsep}Keys");
  copydircontents("Config${dirsep}Keys");

  # There cannot be a territory called 'Backup', so we should be safe here
  if ($bakname ne '') {
    # Don't worry overly if this fails
    rename $bakname, "$currentdir${dirsep}Config${dirsep}Keys${dirsep}Backup$extfff";
  }
  upgrade_done();
}

upgrade_trying("update Config.Menus");
if (-d "$currentdir${dirsep}Config${dirsep}Menus") {
  # FIXME: should try to upgrade (just upgrade source, perhaps?)
  upgrade_done("NOT upgraded: you must merge in changes yourself");
} else {
  my $bakname = '';
  if (-f "$currentdir${dirsep}Config${dirsep}Menus$extfff") {
    upgrade_point("backing up old Menus file");
    $bakname = backupfile("$currentdir${dirsep}Config${dirsep}Menus", $extfff);
    if ($bakname) {
      upgrade_point_done();
    } else {
      upgrade_point_failed();
      exit 1;
    }
  }
  ensuredir("Config${dirsep}Menus");
  copydircontents("Config${dirsep}Menus");
  ensuredir("Config${dirsep}Menus${dirsep}Source");
  copydircontents("Config${dirsep}Menus${dirsep}Source");

  # There cannot be a territory called 'Backup', so we should be safe here
  if ($bakname ne '') {
    # Don't worry overly if this fails
    rename $bakname, "$currentdir${dirsep}Config${dirsep}Menus${dirsep}Backup$extfff";
  }
  upgrade_done();
}

upgrade_trying("update Config.FileID*");
ensurefile("Config${dirsep}FileIdLow", $extfff);
ensurefile("Config${dirsep}FileIdHigh", $extfff);
upgrade_done();

exit 0;

######################################################################
# And core functions used by the above
######################################################################

sub upgrade_trying($) {
  my $mess = shift;
  print STDERR "Trying to $mess ...\n";
}

sub upgrade_done() {
  print STDERR "--------------------------------------------------------------------------------\n";
#  print "done.\n";
}

sub upgrade_point_failed() {
  print STDERR "FAILED.\n";
}

sub upgrade_point($) {
  my $point = shift;
  print STDERR "  $point ... ";
}

sub upgrade_point_fixed() {
  print STDERR "fixed.\n";
}

sub upgrade_point_done() {
  my $m;
  $m = shift or $m='done.';
  print STDERR "$m\n";
}

sub copy($:$) {
  my ($file, $type) = @_;
  if (! defined $type) {
    $type = '';
  }
  upgrade_point("updating $file");
  my $res = system("cp $upgradedir$dirsep$file$type $currentdir$dirsep$file$type");
  if ($res>>8) {
    upgrade_point_failed();
    return 0;
  } else {
    upgrade_point_done();
    return 1;
  }
}

sub copydircontents($) {
  my $dir = shift;
  my $ent;
  opendir DIR, "$upgradedir${dirsep}$dir";
  while ($ent = readdir DIR) {
    if (-f "$upgradedir${dirsep}$dir${dirsep}$ent") {
      ensurefile("$dir${dirsep}$ent");
    }
  }
  closedir DIR;
}

sub ensuredir($) {
  my $dir = shift;
  upgrade_point("ensuring presence of $dir");
  if (! -d "$currentdir$dirsep$dir") {
    mkdir "$currentdir$dirsep$dir", 0775;
    upgrade_point_fixed();
    return 0;
  }
  upgrade_point_done();
  return 1;
}

sub ensurefile($:$) {
  my ($file, $type) = @_;
  if (! defined $type) {
    $type = '';
  }
  upgrade_point("ensuring presence of $file");
  if (! -f "$currentdir$dirsep$file$type") {
    my $res = system("cp $upgradedir$dirsep$file$type $currentdir$dirsep$file$type");
    if ($res>>8) {
      upgrade_point_failed();
      return 0;
    } else {
      upgrade_point_done();
      return 1;
    }
  }
  upgrade_point_done();
  return 1;
}

sub backupfile($:$) {
  my ($file, $type) = @_;
  if (! defined $type) {
    $type = '';
  }
  my $bak = "$file$baksuffix$type";
  my $res = rename "$file$type", $bak;
  if ($res==1) {
    return $bak;
  } else {
    return '';
  }
}

sub getlines() { #$\&@) {
  my ($fname, $functor);
  $fname = shift;
  $functor = shift;
  open FILE, "<$fname" or die "Couldn't open $fname.\n";
  my ($line, @lines);
  @lines = ();
  while ($line = <FILE>) {
    chomp $line;
    if (&{$functor} ($line, \@_)) {
      push @lines, $line;
    }
  }
  close FILE;
  return @lines;
}

sub filterfile() { #$$\&@) {
  my ($from, $to, $functor);
  $from = shift;
  $to = shift;
  $functor = shift;
  open FROM, "<$from" or die "Couldn't open $from.\n";
  open TO, ">$to" or die "Couldn't open $to.\n";
  my $line;
  print TO (&{$functor} (0, "", \@_)) . "\n";  
  while ($line = <FROM>) {
    chomp $line;
    print TO (&{$functor} (1, $line, \@_)) . "\n";
  }
  print TO (&{$functor} (2, "", \@_)) . "\n";  
  close FROM;
  close TO;
}

__END__

=head1 NAME

upgrade-config.pl

=head1 SYNOPSIS

upgrade-config.pl [options] old new

 Options:
  --help          brief help message
  --man           full documentation
  --verbose       run in verbose mode

=head1 OPTIONS

=over 8

=item B<--help>

Print a brief help message and exit.

=item B<--man>

Print the manual page and exit.

=item B<--verbose>

Run in verbose mode.

=back

=head1 DESCRIPTION

B<upgrade-config.pl> upgrades a ZapUser configuration set to work with the
latest version of Zap.

=head1 AUTHOR

James Aylett <dj@zap.tartarus.org>

=cut

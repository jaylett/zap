#!/usr/bin/perl -w

use strict;
use Archive::Zip qw( :ERROR_CODES :CONSTANTS );
use Getopt::Long;
#use Pod::Usage;

my ($progname, $progversion) = ("zipdiff.pl", "1.0");
my ($verbose, $help, $man) = ('', 0, 0);
my ($zip1, $zip2, $outzip, $inzip, $manifest_file) =
  ('', '', '', '', 'Manifest');

Getopt::Long::Configure("bundling");

GetOptions('inzip=s' => \$inzip,
	   'outzip=s' => \$outzip,
	   'manifest=s' => \$manifest_file,
	   'help|?' => \$help,
	   'man' => \$man,
	   'verbose' => \$verbose);# or
#pod2usage(2);
#pod2usage(1) if $help;
#pod2usage(-exitstatus => 0, -verbose => 2) if $man;

$zip1 = shift or die "Missing operand (try --help).";
$zip2 = shift or die "Missing operand (try --help).";

my ($zh1, $zh2);

$zh1 = Archive::Zip->new($zip1) or die "Couldn't open zip '$zip1' for reading.";
$zh2 = Archive::Zip->new($zip2) or die "Couldn't open zip '$zip2' for reading.";

# Okay, let's figure out the manifest:
#  (1) Files in zip1 but not zip2 (REMOVE)
#  (2) Files in both but different (CHANGE)
#  (3) Files in zip2 but not zip1 (ADD)

my (@mem1, @mem2);

@mem1 = $zh1->memberNames();
@mem2 = $zh2->memberNames();

my ($file, @removelist, @changelist, @addlist, @removedirlist, @adddirlist);

foreach $file (@mem1) {
  if ($zh2->memberNamed($file)) {
    # Has it changed?
    my ($member1, $member2);
    if ($member1 = $zh1->memberNamed($file)) {
      if ($member2 = $zh2->memberNamed($file)) {
	if (!$member1->isDirectory() || !$member2->isDirectory()) {
	  if ($member1->isDirectory()) {
	    push @addlist, $file; # directory changed into a file
	    push @removedirlist, $file;
	    if ($verbose) { print "$file: directory -> file\n"; }
	  } else {
	    if ($member2->isDirectory()) {
	      push @removelist, $file; # file changed into a directory
	      push @adddirlist, $file;
	      if ($verbose) { print "$file: file -> directory\n"; }
	    } else {
	      my ($contents1, $contents2);
	      if ($contents1 = $zh1->contents($file)) {
		if ($contents2 = $zh2->contents($file)) {
		  if ($contents1 ne $contents2) {
		    push @changelist, $file;
		    if ($verbose) { print "$file: file changed\n"; }
		  } else {
		    if ($verbose) { print "$file: file unchanged\n"; }
		  }
		} else {
		  warn "Couldn't extract '$file' from '$zip2'";
		}
	      } else {
		warn "Couldn't extract '$file' from '$zip1'";
	      }
	    }
	  }
	} else {
	  if ($verbose) { print "$file: directory unchanged\n"; }
	}
      } else {
	warn "Couldn't read '$file' from '$zip2'";
      }
    } else {
	warn "Couldn't read '$file' from '$zip1'";
    }
  } else {
    my $member1 = $zh1->memberNamed($file);
    if ($member1->isDirectory()) {
      push @removedirlist, $file;
      if ($verbose) { print "$file: directory removed\n"; }
    } else {
      push @removelist, $file;
      if ($verbose) { print "$file: file removed\n"; }
    }
  }
}

foreach $file (@mem2) {
  if (!$zh1->memberNamed($file)) {
    my $member2 = $zh2->memberNamed($file);
    if ($member2->isDirectory()) {
      push @adddirlist, $file;
      if ($verbose) { print "$file: directory added\n"; }
    } else {
      push @addlist, $file;
      if ($verbose) { print "$file: file added\n"; }
    }
  }
}

my $manifest = "Manifest of changes ('$zip1' to '$zip2')\n-------------------\n\n";
if (scalar @removelist > 0) {
  $manifest .= "REMOVE:\n";
  foreach $file (@removelist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @removedirlist > 0) {
  $manifest .= "\nREMOVE DIRECTORIES:\n";
  foreach $file (@removedirlist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @adddirlist > 0) {
  $manifest .= "\nADD DIRECTORIES:\n";
  foreach $file (@adddirlist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @addlist > 0) {
  $manifest .= "\nADD:\n";
  foreach $file (@addlist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @changelist > 0) {
  $manifest .= "\nCHANGE:\n";
  foreach $file (@changelist) {
    $manifest .= "\t$file\n";
  }
}

if ($outzip) {
  my $ozh;

  warn "Cannot merge directly into a zipfile (use different filenames)." if ($outzip eq $inzip);

  if ($inzip) {
    $ozh = Archive::Zip->new($inzip) or die "Couldn't open zip '$inzip' for merging with output.";
  } else {
    $ozh = Archive::Zip->new() or die "Couldn't create output zip.";
  }
  my $member;
    
  foreach $file (@changelist) {
    $member = $zh2->memberNamed($file);
    $ozh->removeMember($file);
    $ozh->addMember($member);
  }
  foreach $file (@adddirlist) {
    $member = $zh2->memberNamed($file);
    $ozh->removeMember($file);
    $ozh->addMember($member);
  }
  foreach $file (@addlist) {
    $member = $zh2->memberNamed($file);
    $ozh->removeMember($file);
    $ozh->addMember($member);
  }
  my $old_manifest = $ozh->contents($manifest_file);
  $ozh->removeMember($manifest_file);
  if ($old_manifest) {
    $manifest = $old_manifest . "\n\n" . $manifest;
  }
  $ozh->addString($manifest, $manifest_file);
  my $cmt = $ozh->zipfileComment();
  if ($cmt) {
    $cmt .= "\n";
  }
  $cmt .= "Diffs between '$zip1' ('" . $zh1->zipfileComment() . "') and '$zip2' ('" . $zh2->zipfileComment() . "')";
  $ozh->zipfileComment($cmt);
  $ozh->writeToFileNamed($outzip)==AZ_OK or die "Couldn't write diffzip to '$outzip'";
} else {
  if ($verbose) { print "\n\n"; }
  print $manifest;
}

__END__

=head1 NAME

zipdiff.pl

=head1 SYNOPSIS

zipdiff.pl [options] zip1 zip2

 Options:
  --help          brief help message
  --man           full documentation
  --verbose       run in verbose mode
  --outzip FILE   produce zipfile of diffs, not manifest
  --inzip FILE    zipfile to augment when producing diffs zipfile
  --manifest NAME name of manifest file in zip (default: Manifest)

=head1 OPTIONS

=over 8

=item B<--help>

Print a brief help message and exit.

=item B<--man>

Print the manual page and exit.

=item B<--outzip>

Produce a zipfile of changed/new files or diffs, not just a manifest.

=item B<--inzip>

Zipfile to merge with to produce output zipfile.

=item B<--verbose>

Run in verbose mode.

=back

=head1 DESCRIPTION

B<zipdiff.pl> compares two zip files, producing either a manifest of
which files have changed, or a zipfile of the change/new files, or of
diffs.

=head1 AUTHOR

James Aylett <dj@zap.uk.eu.org>

=cut

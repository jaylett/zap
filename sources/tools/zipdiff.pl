#!/usr/bin/perl -w

use strict;
use Archive::Zip qw( :ERROR_CODES :CONSTANTS );
use Getopt::Long;
#use Pod::Usage;

my ($progname, $progversion) = ("zipdiff.pl", "1.0");
my ($verbose, $help, $man) = ('', 0, 0);
my ($zip1, $zip2, $outzip) = ('', '', '');

Getopt::Long::Configure("bundling");

GetOptions('outzip=s' => \$outzip,
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

my ($file, @removelist, @changelist, @addlist);

foreach $file (@mem1) {
  if ($zh2->memberNamed($file)) {
    # Has it changed?
    my ($contents1, $contents2);
    if ($contents1 = $zh1->contents($file)) {
      if ($contents2 = $zh2->contents($file)) {
	if ($contents1 eq $contents2) {
	} else {
	  push @changelist, $file;
	}
      } else {
	warn "Couldn't extract '$file' from '$zip2'";
      }
    } else {
      warn "Couldn't extract '$file' from '$zip1'";
    }
  } else {
    push @removelist, $file;
  }
}

foreach $file (@mem2) {
  if (!$zh1->memberNamed($file)) {
    push @addlist, $file;
  }
}

my $manifest = "Manifest of changes ('$zip1' to '$zip2')\n-------------------\n\n";
if (scalar @removelist > 0) {
  $manifest .= "REMOVE:\n";
  foreach $file (@removelist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @addlist > 0) {
  $manifest .= "ADD:\n";
  foreach $file (@addlist) {
    $manifest .= "\t$file\n";
  }
}
if (scalar @changelist > 0) {
  $manifest .= "CHANGE:\n";
  foreach $file (@changelist) {
    $manifest .= "\t$file\n";
  }
}

if ($outzip) {
  my $ozh = Archive::Zip->new();
  foreach $file (@changelist) {
    $ozh->addMember($zh2->memberNamed($file));
  }
  foreach $file (@addlist) {
    $ozh->addMember($zh2->memberNamed($file));
  }
  $ozh->addString($manifest, 'Manifest');
  $ozh->zipfileComment("Diffs between '$zip1' ('" . $zh1->zipfileComment() . "') and '$zip2' ('" . $zh2->zipfileComment() . "')");
  $ozh->writeToFileNamed($outzip)==AZ_OK or die "Couldn't write diffzip to '$outzip'";
} else {
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

=head1 OPTIONS

=over 8

=item B<--help>

Print a brief help message and exit.

=item B<--man>

Print the manual page and exit.

=item B<--outzip>

Product a zipfile of changed/new files or diffs, not a manifest.

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

#! /usr/bin/perl -w
#
# macrofy
#
# Convert various STMs and LDMs to macro equivalents
# Warn on ARM26 constructs
#
# Author: Darren Salt
# (c) Zap Developers 2001
#
# This isn't perfect.
# Passing the input and output files through sdiff is recommended.


$version = '$Id: macrofy.pl,v 1.2 2001/04/26 01:02:52 ds Exp $';

$version =~ /^.*?,v (.*?) (.*?) .*$/;
$version = $1.', '.$2;

use Getopt::Long;

$STM1 = qr/STMFD[ \t]+(?:r13|sp) ?!, ?\{(?:r14|lr)\}/i;
$STMM = qr/STMFD([ \t]+)(?:r13|sp) ?!, ?\{(.*), ?(?:r14|lr)\}/i;

sub find_stm (;$)
{
  local $l = shift;
  $l = -1 unless defined $l;
  local $m = $#asm;
  while (++$l <= $m) {
    return $l if $asm[$l] =~ $STM1 || $asm[$l] =~ $STMM;
  }
  return undef;
}

Getopt::Long::Configure ('bundling');
die unless GetOptions ('help|h', 'version|v', 'verbose|V+') or die; # hmm :-)
$opt_verbose = 0 unless defined $opt_verbose;

print '' if defined $opt_help || defined $opt_version; # used once only? no :-)

if (defined $opt_help) {
  print <<EOF;
$0 $version
Converts various STMs and LDMs to macro equivalents.
Warns on ARM26 constructs.
Input must be in objasm/as format.

Usage: $0 [options] < infile > outfile

  -V --verbose   Be verbose (more times, more verbose)
  -h --help      Display this help
  -v --version   Display the version number
EOF
  exit 0;
}

if (defined $opt_version) {
  print $version, "\n";
  exit 0;
}

print STDERR "Reading file...\n"
  if $opt_verbose;
while ($line = <>) {
  chomp $line;
  push @asm, $line;
}

$stmline = find_stm ();

while (defined $stmline) {
  $nextstm = find_stm ($stmline);
  $endline = defined $nextstm ? $nextstm - 1: $#asm;
  print STDERR 'Parsing lines ', $stmline, ' to ', $endline, "\n"
    if $opt_verbose;
  print STDERR ' < ',$asm[$stmline]
    if $opt_verbose > 1;
  $asm[$stmline] =~ s/$STM1/FNJSR/io
    unless $asm[$stmline] =~ s/$STMM/FNJSR$1"$2"/io;
  $reglist = defined $2 ? $2 : '';
  print STDERR "\n > ",$asm[$stmline],"\n"
    if $opt_verbose > 1;

  foreach $i (@asm[$stmline+1 .. $endline]) {
    $a = $i;
    if	  ($i =~ /LDM.*^/io) {
      # LDM..{..PC}^
      $i =~ s/LDM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{.*, ?(?:r15|pc)\}^/FNRTSS$2$1/io
      unless $i =~ s/LDMFD[ \t]+(?:r13|sp) ?!, ?\{.*(?:r15|pc)\}^/FNRTSS/io;
    }
    elsif ($i =~ /LDM/io) {
      $i =~ /\{()(?:r1[45]|lr|pc)\}/io
      unless $i =~ /\{(.*), ?(?:r1[45]|lr|pc)\}/io;
      if (defined $1 && $reglist eq $1) {
	if ($i =~ /(?:r15|pc)\} ?\^/io) {
	  # LDM..{..PC}
	  $i =~ s/LDM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{.*(?:r15|pc)\} ?\^/FNRTSS$2$1/io
	  unless $i =~ s/LDMFD[ \t]+(?:r13|sp) ?!, ?\{.*(?:r15|pc)\} ?\^/FNRTSS/io;
	} elsif ($i =~ /(?:r15|pc)\}/io) {
	  # LDM..{..PC}
	  $i =~ s/LDM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{.*(?:r15|pc)\}/FNRTS$2$1/io
	  unless $i =~ s/LDMFD[ \t]+(?:r13|sp) ?!, ?\{.*(?:r15|pc)\}/FNRTS/io;
	} else {
	  # LDM..{..LR}
	  $i =~ s/LDM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{.*(?:r14|lr)\}/FNPULL$2$1/io
	  unless $i =~ s/LDMFD[ \t]+(?:r13|sp) ?!, ?\{.*(?:r14|lr)\}/FNPULL/io;
	}
      } else {
        $i =~ s/$/\t; !!! Unmatched return LDM/o
          if $i =~ /(?:r1[45]|lr|pc)\}/io;
	# LDM..{..}
	$i =~ s/LDM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{(.*)\}/PULL$2"$3",$1/io
	unless $i =~ s/LDMFD([ \t]+)(?:r13|sp) ?!, ?\{(.*)\}/PULL$1"$2"/io;
      }
    }
    elsif ($i =~ /STM/io) {
      # STM..{..} not PC
      $i =~ s/STM(..)FD([ \t]+)(?:r13|sp) ?!, ?\{(.*)(?<!pc)(?<!r15)\}/PUSH$2"$3",$1/io
      unless $i =~ s/STMFD([ \t]+)(?:r13|sp) ?!, ?\{(.*)(?<!pc)(?<!r15)\}/PUSH$1"$2"/io;
    }
    elsif ($i =~ /(TEQ|TST|CM[NP])(..)?P/io) {
      # TEQP, TSTP, CMPP, CMNP
      $i =~ s/$/\t; !!! ARM32 FIXME/o;
    }
    elsif ($i =~ /[A-Za-z]{3}(..)?S[ \t]+(pc|r15)/io) {
      # Anything writing to PC+flags
      $i =~ s/$/\t; !!! ARM32 FIXME/o;
    }
    print STDERR ' < ',$a,"\n > ",$i,"\n"
      if $opt_verbose > 1 && $a ne $i;
  }

  $stmline = $nextstm;
}

print STDERR "Writing file...\n"
  if $opt_verbose;

foreach $i (@asm) {
  print $i,"\n" or die $!;
}
exit 0;
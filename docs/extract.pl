#!/usr/bin/perl

my ($state, $start, $end, $line, $last) = (0,"","");
open INPUT, "src/Chapter02,fff" or die "Can't open Chapter 2 source";
while ($line = <INPUT>) {
  chomp $line;

  $line =~ s/\\.//;
  $line =~ s/{(.*)}//;
  $line =~ s/^ *(.*) *$/$1/;

  if ($state==1 && $line ne "") {
    $start = $line;
    $state = 0;
  }
  ($line =~ /CHAPTER-2-STARTS-HERE/) and $state = 1;
  ($line =~ /CHAPTER-2-ENDS-HERE/) and $end = $last;
  if ($line ne "") {
    $last = $line;
  }
}
$state = 0;
close INPUT;

open OUTPUT, ">install.txt" or die "Can't write out install document";
open MANUAL, "output.txt" or die "Can't open manual";
while ($line = <MANUAL>) {
  ($line =~ /$start/) and $state=1;
  if ($state==1) {
    print OUTPUT $line;
  }
  ($line =~ /$end/) and $state=0;
}
close MANUAL;

#!/usr/bin/perl -w

use strict;

my ($dir1, $dir2, $destdir);

$dir1 = shift or die "Please given three operands (old, new and target directories).";
$dir2 = shift or die "Please given three operands (old, new and target directories).";
$destdir = shift or die "Please given three operands (old, new and target directories).";

my ($ver1, $ver2);
$ver1 = $dir1;
$ver1 =~ s/^(.*)test([0-9]*)(.*)$/$2/;
$ver2 = $dir2;
$ver2 =~ s/^(.*)test([0-9]*)(.*)$/$2/;

# Core upgrade
print "Creating core$ver1-$ver2.zip ...\n";
system ("zipdiff.pl --manifest='Manifest.txt' --outzip=$destdir/core$ver1-$ver2.zip $dir1/devel.zip $dir2/devel.zip");

# Fonts upgrade
print "Creating fonts$ver1-$ver2.zip ...\n";
system ("zipdiff.pl --manifest='Manifest.txt' --outzip=$destdir/fonts$ver1-$ver2.zip $dir1/zapfonts.zip $dir2/zapfonts.zip");

# Mods upgrade
print "Creating mods$ver1-$ver2.zip ...\n";
system ("zipdiff.pl --manifest='Manifest.txt' --outzip=/tmp/upgrade1.zip $dir1/descmods.zip $dir2/descmods.zip");
system ("zipdiff.pl --manifest='Manifest.txt' --inzip=/tmp/upgrade1.zip --outzip=/tmp/upgrade2.zip $dir1/develmods.zip $dir2/develmods.zip");
system ("zipdiff.pl --manifest='Manifest.txt' --inzip=/tmp/upgrade2.zip --outzip=/tmp/upgrade1.zip $dir1/devel+mods.zip $dir2/devel+mods.zip");
system ("zipdiff.pl --manifest='Manifest.txt' --inzip=/tmp/upgrade1.zip --outzip=/tmp/upgrade2.zip $dir1/mainmods.zip $dir2/mainmods.zip");
system ("zipdiff.pl --manifest='Manifest.txt' --inzip=/tmp/upgrade2.zip --outzip=/tmp/upgrade1.zip $dir1/riscosmods.zip $dir2/riscosmods.zip");
system ("zipdiff.pl --manifest='Manifest.txt' --inzip=/tmp/upgrade1.zip --outzip=$destdir/mods$ver1-$ver2.zip $dir1/webmods.zip $dir2/webmods.zip");

system ("rm /tmp/upgrade1.zip");
system ("rm /tmp/upgrade2.zip");

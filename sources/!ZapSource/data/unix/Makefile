# Make file for Zap Text Editor (linux build)
# (c) James Aylett <dj@zap.uk.eu.org>
#
# Note to users: read as far as the --- [System] --- line
# Note to developers: read as far as the --- [Build] --- line
#
# This makefile requires GNU make. The build system also requires
# as_ro (the Unix port of !AS by Niklas R�jemo, Nick Burrett, Darren Salt
# and Andy Duplain), and link_ro (any AOF linker that will accept the -B 0
# -bin switches). Both are available from the Zap website, in the CVS
# section:
# <URL:http://www.zap.uk.eu.org/cvs/>
# Some of the internal build scripts need Perl and sed.
#
# Targets supported are: Zap (the default target), which builds the core
# module as ./Zap,ffa (so it's filetyped 'Module' for NFS), and clean,
# which deletes object and temporary header files, and the final target
# if present.

# It currently won't rebuild h/ZapHeader,fff, but then I personally
# dislike having the BASIC version as the source anyway ...
# (Doing this would require porting Dominic's BasicToAsm, which isn't
# pleasant ...)
#
# Note that this file will create both header files and
# object files with *no* NFS extension. Do a make clean before
# packaging everything up and sending it off to anyone (it's
# polite anyway).
# (If this is ever seen as being a problem, it's fairly easy to
# change.)

# --- [System] ---
#
# You'll need to change the following if you add additional compilation
# units.

OBJECTS		= o/Dispatch o/Redraw o/Template o/Messages o/Cursors \
		  o/CreateWind o/AlterTxt o/Search o/Commands o/Execute \
		  o/Update o/Mode0 o/Mode1+2 o/Mode3 o/Mode4 o/Mode4dis \
		  o/ModeBits o/Mode11 o/SoftWrap o/KeyBits o/Strings \
		  o/CreateFile o/Undo o/Menus o/MiniBuff o/StartCode \
		  o/StartUp o/Heap o/Boxes o/Fonts o/Exceptions \
		  o/ModuleBits o/TMFs o/LineEditor o/TabStops

# You may need to change some of the following if your system is different
# to mine. (Link and Asm need to point to as_ro and link_ro, whatever
# they are called on your system. The flags shouldn't need to be changed
# unless you're using a different version of the tools.)

asm		= as_ro
link		= link_ro
asmflags	= -objasm -nolocal -upper -pedantic -DASSEMBLER=AS -target ARM6 -o $@
linkflags	= -o o/tmplink -B 0 -bin

# Bits we use to grab the build parameter to make ...
__BUILD		= "-DBUILD=$(BUILD)"
NEWBUILD	= BUILD=$(BUILD)

# We need rm, but it's almost always the same. You may need to change
# this on dubious Unixoids so we're using GNU rm instead of the vendor
# one.
rm		= rm -f

# --- [Build] ---
#
# First, the internal tools we use
makehdr		= data/unix/makehdr
timestamp	= perl -pe "s/00 Jan 0000/`date +'%d %b %Y'`/"

# The bits after here are fairly standard GNU make incantations.
# Watch out for variable substitution (the $(subst) stuff), which
# means I only need the one big variable to identify all the object files.
# Check the make documentation (info make) for details.

t/%:		s/%,fff
		$(makehdr) -t $@ -h $(subst t/,h/,$(@)) -s $<

# Always rebuild when ZapHeader changes ...
o/%:		s/%,fff h/ZapHeader,fff
		$(asm) $(asmflags) $(__BUILD) $<

# Final target:

Zap,ffa:	objdirs o/tmplink
		$(timestamp) < o/tmplink > Zap,ffa

objdirs:
		mkdir -p o
		mkdir -p t

o/tmplink:	$(subst o/,t/,$(OBJECTS)) $(OBJECTS)
		$(link) $(linkflags) $(OBJECTS)

clean:
		$(rm) o/* t/* $(subst o/,h/,$(OBJECTS)) Zap,ffa

#h.ZapLibrary:	<Zap$Dir>.Docs.TechCode.E-Library
# Run $(ZapS).data.BasicToAsm <Zap$Dir>.Docs.TechCode.E-Library RAM:ZapTemp
# COPY RAM:ZapTemp $(ZapS).h.ZapLibrary ~C~VNSFD

# This target relies on sources/tools/ being checked out as part of the
# sources hierarchy (of which this is sources/!ZapSource/), and that
# asmtobasic has been built within it
E-Library,ffb:	h/ZapLibrary,fff
		../tools/asmtobasic h/ZapLibrary,fff E-Library,ffb

o/ModuleBits:	h/Version,fff


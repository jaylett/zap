# Make file for ZapRedraw under unix
# (c) Darren Salt, James Aylett

# For the standard build name:
#	make -r -f data/unix/Makefile
# For alternative build names:
#	make -r -f data/unix/Makefile BUILD=foo
#	make -r -f data/unix/Makefile BUILD=foo-42
#    "-<n>" is automatically appended if you omit it.

# Targets:
#	ZapRedraw (default)	Build ZapRedraw
#	clean			Wipe .o and .t files, and auto-gen headers

OBJECTS		=  o/ZapRedraw o/DSARedraw o/VDURedraw

asm		= as_ro
link		= link_ro
asmflags	= -nolocal -objasm -upper -pedantic -I$(ZapSource_Dir) -o $@
linkflags	= -o o/tmplink -B 0 -bin

__BUILD		= "-DBUILD=$(BUILD)"

makehdr		= $(ZapSource_Dir)/data/unix/makehdr
timestamp       = perl -pe "s/00 Jan 0000/`date +'%d %b %Y'`/"
rm		= rm -f

t/%:		s/%,fff
		$(makehdr) -t $@ -h $(subst t/,h/,$(@)) -s $<

# Always rebuild when ZapRedHdr changes!
o/%:		s/%,fff h/ZapRedHdr,fff
		$(asm) $(__BUILD) $(asmflags) $<

# Final target
ZapRedraw:	objdirs tmplink
		$(timestamp) < o/tmplink > ZapRedraw,ffa

objdirs:
		mkdir -p o
		mkdir -p t

tmplink:	$(subst o/,t/,$(OBJECTS)) $(OBJECTS)
		$(link) $(linkflags) $(OBJECTS)

clean:
		$(rm) o/* t/* $(subst o/,h/,$(OBJECTS)) ZapRedraw,ffa

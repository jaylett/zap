# Make file for ZapBASIC under unix
# (c) Darren Salt, James Aylett

# For the standard build name:
#	make -r -f data/unix/Makefile
# For alternative build names:
#	make -r -f data/unix/Makefile BUILD=foo
#	make -r -f data/unix/Makefile BUILD=foo-42
#    "-<n>" is automatically appended if you omit it.

# Targets:
#	ZapBASIC (default)	Build ZapBASIC
#	clean			Wipe .o and .t files, and auto-gen headers

OBJECTS		=  o/ZapBASIC o/BASIC o/BAStxt o/Brackets o/Buttons \
		   o/TaskWindow o/Toggle

asm		= as_ro
link		= link_ro
asmflags	= -nolocal -objasm -upper -pedantic -I$(ZapSource_Dir) -o $@
linkflags	= -o o/tmplink -B 0 -bin

__BUILD		= "-DBUILD=$(BUILD)"
__INTL		= "-DINTL=$(INTL)"
__TMFS		= "-DTMFS=$(TMFS)"

makehdr		= $(ZapSource_Dir)/data/unix/makehdr
timestamp       = sed -e "s/00 Jan 0000/`date +'%d %b %Y'`/"
rm		= rm -f

t/%:		s/%,fff
		$(makehdr) -t $@ -h $(subst t/,h/,$(@)) -s $<

# Always rebuild when ZapBasHdr changes!
o/%:		s/%,fff h/ZapBasHdr,fff
		$(asm) $(__BUILD) $(__INTL) $(__TMFS) $(asmflags) $<

# Final target
ZapBASIC:	objdirs tmplink
		$(timestamp) < o/tmplink > ZapBASIC,ffa

objdirs:
		mkdir -p o
		mkdir -p t

tmplink:	$(subst o/,t/,$(OBJECTS)) $(OBJECTS)
		$(link) $(linkflags) $(OBJECTS)

clean:
		$(rm) o/* t/* $(subst o/,h/,$(OBJECTS)) ZapBASIC,ffa

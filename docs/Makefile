# Make file for Zap documentation
# (c) James Aylett <dj@zap.tartarus.org>

chapters 	= $(wildcard src/Chapter*,fff)
appendices	= $(wildcard src/Appendix*,fff)
controlfiles	= $(wildcard src/Manual*,fff)

buttress	= $(HOME)/projects/tartarus/buttress/build/buttress
butt_options	=

# We need rm, but it's almost always the same. You may need to change
# this on dubious Unixoids so we're using GNU rm instead of the vendor
# one.
# If cp needs changing, your Unix is very odd.
rm		= rm -f
cp		= cp

# Final target:
zapdocs:		manual install website

debug:		$(chapters) $(appendices) $(controlfiles)
		$(buttress) -d $(butt_options) $(chapters) $(appendices) $(controlfiles)

manual:		$(chapters) $(appendices) $(controlfiles)
		$(buttress) $(butt_options) $(chapters) $(appendices) $(controlfiles)

install:	manual
		perl extract.pl

# The @test line is so that this target does nothing if WEBDIR
# isn't defined.
website:	manual
		@test true
ifneq ($(WEBDIR),)
		$(cp) *.html $(WEBDIR)
endif

clean:
		$(rm) *.html output.* install.txt

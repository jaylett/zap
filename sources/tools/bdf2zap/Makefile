# $Id: Makefile,v 1.1 2004/03/30 12:35:32 james Exp $
# UNIX Makefile for bdf2zap

all: bdf2zap

CC = gcc
CCFLAGS = -I.

bdf2zap: c/main,fff h/commands,fff
	$(CC) $(CCFLAGS) -o bdf2zap -x c c/main,fff

clean:
	rm bdf2zap

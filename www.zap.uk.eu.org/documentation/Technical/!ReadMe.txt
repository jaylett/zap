*************************************************************************
* >ReadMe	Introduction to Zap technical documentation.		*
*************************************************************************

This file provides introductory information which should help understand the
terminology used by the other files in the 'Docs.Technical' directory.

This file is split into 4 sections:

	Section A:	How Zap works.

	Section B:	Writing extension modes.

	Section C:	Adding new commands to Zap.
	
	Section D:	Zap extensions

Please read them in this order.

The following abbreviations/notations will be used in the documentation
files:

'\E'	=	The entry conditions for this subroutine are ...
'\X'	=	The exit conditions for this subroutine are ...

The following register conventions will be used:

R8	=	Window block pointer. (See E-Windows for defn)
R9	=	File block pointer. (See E-File for defn)
R10	=	Cursor block pointer. (See E-Cursors for defn)
R11	=	Extension mode's workspace.
R12	=	Zap module's workspace.
R13	=	Full descending stack (1K), bottom = &8000.

Thus for example:

\E R8/R9

This means that on entry, the subroutine has R8 pointing to the window
block, and R9 pointing to a file block on some file (the file the call deals
with). See also the files E-Zapcalls and E-Entry for the standard entry/exit
conditions of most Zap calls.

Two BASIC programs are provided for you in the Docs.TechCode directory. The
first, E-Library defines all the Zap variable names you will need. The
second, E-Template gives a template program for producing new modes/adding
command tables. It creates a mode called 'Test' with mode number 15 based on
text mode, and adds a command table with the command 'BEEPBEEP'.


*************************************************************************
* Section A:	How Zap works.						*
*************************************************************************

When Zap starts up it initialises a 1K stack, claims fixed size buffers and
initialises an operating system heap. File buffers are stacked on top of the
heap and shifted about as the heap or other files changes size. Thus Zap's
memory map can be summarised as:

		TOP	Wimpslot end.
			File n.
			...
			File 1.
			Heap.
			Fixed size buffers.
		&8000	Processor stack (R13) full descending.

To find out how to call Zap please see the file E-Zapcalls. All Zap calls
will be described by their name beginning "Zap_". The calls Zap_Claim,
Zap_Free, Zap_Ensure should be used to claim blocks from the heap. The call
Zap_SplitBuffer should be used to change the buffer size of a file.

Each file has a corresponding file block giving information about that file.
By convention R9 is used to hold a file block pointer. New file buffers can
be created via Zap_CreateFile, Zap_CreateFileBlk, Zap_InstallFile and can be
deleted via Zap_DeleteFile, Zap_DiscardFile. Files are stored in split buffer
form. Please see E-File for details.

Similarly, each window has a corresponding information block. By convention a
window block pointer is held in R8. Each window block determines uniquely a
file block, giving the file showing in the window. Please see the file
E-windows for details. New editing windows can be created by Zap_CreateFile,
Zap_CreateWindBlk, Zap_InstallFile, Zap_NewView and can be deleted by
Zap_DeleteWindow, Zap_DiscardWindow.

Cursor information blocks are described in the file E-Cursors. Cursor block
pointers are conventionally held in R10. Zap's internal variables can be read
by the call Zap_ReadVar and written by Zap_WriteVar. See the file E-Vars for
details. By using this call you may read the block pointers of the standard
cursor blocks.

Inserting/deleting/replacing data in files is accomplished via the calls
Zap_Command and Zap_DoCommand. The former calls the extension mode to perform
the required action and the latter is the low level call which performs the
action directly. Thus in practice, Zap_Command calls the extension mode which
then calls Zap_DoCommand. In this way the extension mode may alter the action
of all inserts or deletes. For example, text mode uses this to accomplish
wordwrap on all operations. See the file E-Zapcalls and E-Entry for more
details.

Please use the Zap_StartOp/Zap_StopOp structure to concatenate insertions/
deletions. This will give smooth update and will ensure that the operation is
undone with only one press of the undo key.


*************************************************************************
* Section B:	Writing extension modes.				*
*************************************************************************

Zap extension modes are numbered 0-255. Currently we have only reserved space
for 32 of these (numbered 0-31). A mode consists of a table of entry points
and flags. This should be held in a module so that the code is always 'mapped
in to memory'. Default defined modes are listed below. 

	0	Text
	1	Byte
	2	Word
	3	ASCII
	4	Code

Before you start writing an extension mode, you should be familiar with
writing modules (preferably in assembler). In most cases, you will simply
wish to 'doctor' the input/output of one of the currently defined mode entry
points. For example, you may wish to change the typed characters entry point
of the Text mode to change `` to a left double quote. This is fairly simple
to do. If, however, you wish to write a full blown mode with, for example,
it's own display format, then you are strongly advised to contact Zap's
developers first.  They should be able to provide some support in addition
to the information given in these text files, and may be able to add any new
Zap calls and entry points that you may require.

To install a new mode you should write a module, which on initialisation
calls Zap_AddMode with a pointer to the mode table. The location of this
module should then be added to the external file so Zap will know where to
load it from.  When Zap loads a module, it will examine the mode entry point
table and copy it into its workspace, converting module offsets to actual
addresses in the process. The call Zap_ReadMode can be used to find the
address of both these tables for any given mode. Hence you can manually alter
the mode entry point of any mode.

The entry point table format is described in the file E-Entry. Please note
that you only have to fill in the first 8 words. In the fourth entry you
specify a BASE MODE. This mode is called instead of yours for all the mode
entry points you don't want to support/change. Hence in most cases you will
set a base mode of 0 (ie Text), and set all of the entry points except those
you wish to change to 0.

Not all modes may be used as base modes.  In particular modes 1,2,3,4
(Byte, Word, ASCII, Code) cannot be used as base modes, nor can the modes
provided by ZapMJE conveniently be used.  This has been the case for quite
some time and hasn't caused any problems.  BASIC, BASTXT modes should work in
principle, but in practice (as these modes are not present in Zap's core)
basing modes on them has not proved practical.

The recommended procedure is currently to always base your mode on Text
mode, and then pass calls on to other modes (if you need the functionality
provided by them) manually.

If an extension provides more than one mode, then these may be based on one
another.  If you do want to base modes on the other existing core modes then
the following information about how they use their mode words may be of use.

Modes 1-4 have a single word mode word. Contents:

Modes 1 and 2:

  b0-b7		the number of byte/word groups
  b8		suppress control characters
  b9		group bytes in number dump
  b10		group bytes in ascii dump
  b11		binary number dump (not hex)
  b12-b15	reserved
  b16-b23	replacement character for control chars
  b24-b27	number of bytes/words in a group
  b28-b31	reserved

Mode 3:

   b0-b15	the width in bytes
  b15-b31	reserved

Mode 4:

   b0-b7	the width in characters
   b8-b27	debugger flags
  b28-b31	misc flags

These structures are not guaranteed to remain in this format; please contact
the authors if you need to access the information in any way.


*************************************************************************
* Section C:	Adding new tables of commands				*
*************************************************************************

Zap currently has space reserved for up to 32 command tables, though this can
easily be increased. The Zap and ZapBASIC modules each use one, leaving 30
for other uses. A command table consists of a pointer to a table of commands
as described in the file E-Commands. The command table should be stored in a
module and registered with Zap when the module initialises by calling the Zap
entry point Zap_AddCommands.

See the file E-Command for fuller details.

*************************************************************************
* Section D:	Zap extensions						*
*************************************************************************

As of version 1.36, Zap extensions should be created as application
directories. The following files are standard and have specific meanings:
	!ZapBoot	Run when Zap is first seen by the filer;
	!ZapRun		Run when Zap is started by the user;
	External (*)	See below;
	HelpData (*)	Help about your modes and commands;
	Types		Types and paths for your mode (see below).

(*) indicates a required file.

Since extensions are normal application directories, they should contain
!Sprites (and possibly !Sprites22, !Sprites23) and !Help files. !Run will
typically do the following:

| !Run file for my Zap extension

IconSprites <Obey$Dir>.!Sprites
Error My Zap extension cannot be started manually.
      ...Please copy it into !Zap.Modules and reload Zap.

In addition, the following filenames should be used for the specific type of
resource:
	!Setup		Setup required before loading the file;
	ExternCmd	Used by MakeExtern (see below);
	Menus		Zap-format menus file;
	Scripts		Scripts used to provide button bars (see below);
	SpritesXX	Any sprites you use internally.

Extension Types files
---------------------

Many extensions provide modes for editing particular types of files. In
older versions of Zap, lines had to be added to a central file to configure
this - but now it can be done in the extension directory. You can put any
&5xx (path check) or &1xxx (filetype check) variable in your Types file -
see the manual for details of how to use them.

Extension External files
------------------------

The format of the external file is explained in Docs.Technical.External.
However you can generate External files automatically using MakeExtern.
Create a file in your application directory called ExternCmd, consisting of
an entry for each module you have written. The entry is of the form:

leafname [command]
	[message list (one number per line, &hex)]

and is terminated by a blank line. You do not need to list modules which do
not require initialisation command and do not handle messages. For those you
/do/ list, remember that the leafname is case sensitive.

The command is a command your module needs to be run before it is loaded:
typically you'll want to use 'Obey @.!Setup' which will run the !Setup file
in your application directory. (If you have multiple modules per extension,
you may need more than one setup file; however in general you shouldn't need
to do this.)

The message list is a list of Wimp message numbers which your extension can
handle.

If the ExternCmd file would be empty, you don't need one at all.

Then you can run the command:

Run <Zap$Dir>.Code.MakeExtern.MakeExtern -ext <name>

...where <name> is the name of the application directory for your extension
(without the '!').

More or less every current extension uses MakeExtern to generate its
External file, so you can look at them to see how it works. Additionally,
the source to the combined command extensions (ZapText, ZapUtil etc.)
contains a step to create the External file using MakeExtern as part of the
build process.

For more information about MakeExtern, see the documentation that comes with
it in Code.MakeExtern.

Button bars for your mode
-------------------------

If you wish to add a button bar to your mode (such as currently available in
Email, BASIC and several others), you will need to use the features supplied
by the ZapButtons extension. For more information, see the documentation
which comes with it.

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

Please read them in this order, and please read right through all sections.

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

This means that on entry, the subroutine has R8 pointing to the window block,
and R9 pointing to a file block on some file (the file the call deals with).
See also the files E-Zapcalls and E-Entry for the standard entry/exit
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
	5	HalfWord
	6	DoubleWord
	11	Throwback

Before you start writing an extension mode, you should be familiar with
writing modules (preferably in assembler). In most cases, you will simply
wish to 'doctor' the input/output of one of the currently defined mode entry
points. For example, you may wish to change the typed characters entry point
of the Text mode to change `` to a left double quote. This is fairly simple
to do. If, however, you wish to write a full blown mode with, for example,
it's own display format, then you are strongly advised to contact Zap's
developers first.  They should be able to provide some support in addition to
the information given in these text files, and may be able to add any new Zap
calls and entry points that you may require.

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

Only the built-in modes may be used as base modes, and of these, Text mode is
most usefully used in this way. Extension modes cannot be used in this way
because there's no guarantee as to the allocation of mode numbers (which
depends on the order in which you use the modes).

The recommended procedure is currently to always base your mode on Text mode,
and then pass calls on to other modes (if you need the functionality provided
by them) manually.

If an extension provides more than one mode, then these may be based on one
another; this may be done by code sharing (ie. the same routines referenced
in the unlinked mode tables) or by telling Zap about one mode then writing
its mode number into the unlinked mode table for the next mode, about which
you then tell Zap.

If you do want to base modes on the other existing core modes then the
following information about how they use their mode words may be of use.

Modes 1-5 each have a single word mode word. Contents:

Modes 1, 2 and 5:

  b0-b7		the number of byte/word groups [temporary]
  b8		suppress control characters
  b9		group bytes in number dump
  b10		group bytes in ascii dump
  b11		binary number dump (not hex)
  b12-b15	reserved
  b16-b23	replacement character for control chars
  b24-b27	number of bytes/words in a group
  b28-b31	mode type (0 = byte, 1 = halfword, 2 = word, 3 = doubleword)

Mode 3:

   b0-b15	the width in bytes [temporary]
  b15-b31	reserved

Mode 4:

   b0-b7	the width in characters [temporary]
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
directories. Each extension should contain only one RISC OS module.

As of version 1.41, the following files are standard and have specific
meanings:

	!Help	 (+)	Detailed documentation on the extension;
	!Run	 (+)	Give a message on installing into !Zap.Modules;
	!SpritesXX (+)	Filer icons for the extension;
	!ZapBoot	Run when Zap is first seen by the filer;
	!ZapRun		Run when Zap is started by the user;
	External (*)	See below;
	HelpData (*)(%)	Help about your modes and commands;
	Messages (+)(%)	MessageTrans tokens for your modes' & commands' use;
	Types (%)	Types and paths for your mode (see below).

(*) indicates a required file.
(+) indicates a strongly recommended file.
(%) indicates a file that can be usefully internationalised (see below).

Since extensions are normal application directories, they should contain
!Sprites (and possibly !Sprites22, !Sprites23) and !Help files. !Run will
typically do the following:

| !Run file for my Zap extension

IconSprites <Obey$Dir>.!Sprites
Error My Zap extension cannot be started manually.
      ...Please copy it into !Zap.Modules and reload Zap.

The tokens in Messages files must be named "<mode>_<identifier>" or
"<module>_<identifier>", eg. "basic_colours" or "zapbits_unclaimed". The
<identifier> part can be anything you like - within reason :-)

In addition, the following filenames should be used for the specific type of
resource:
	!Setup		Setup required before loading the file (see below);
	ExternCmd	Used by MakeExtern (see below);
	Menus (%)	Zap-format menus file;
	Keys (%)	Per-mode keymaps file;
	Scripts	(%)	Scripts used to provide button bars (see below);
	SpritesXX (%)	Any sprites you use internally;
	Templates (%)	Template file for button bars (see below);
	TMF		TMF for your mode (if you have multiple modes, then
			use a directory, TMFs).

(%) indicates a file that can be usefully internationalised (see below).

Extension Types files
---------------------

Many extensions provide modes for editing particular types of files. In older
versions of Zap, lines had to be added to a central file to configure this -
but now it can be done in the extension directory. You can put any &5xx (path
check) or &1xxx (filetype check) variable in your Types file - see the manual
for details of how to use them.

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

More or less every current extension uses MakeExtern to generate its External
file, so you can look at them to see how it works. Additionally, the source
to the combined command extensions (ZapText, ZapUtil etc.) contains a step to
create the External file using MakeExtern as part of the build process.

For more information about MakeExtern, see the documentation that comes with
it in Code.MakeExtern.

Extension TMFs
--------------

TMFs are "Textual Mode Files"; they are per-mode files storing c-var
definitions that are loaded at the start of a session. (In the future,
c-vars will be able to be overridden per-file, but currently they cannot be
changed from their definitions in the mode's TMF.) For more information
about c-vars, see the manual.

TMFs take the form of a MessageTrans file, and so might look something like:

---8<-------------------------------------------------
# TMF for MyMode
HelpSearchPath:SWI,OS,Wimp,InetSocket,InetSWIs,
IncoreFilenameStart:>>Name: 
IncoreFilenameEnd:<<
---8<-------------------------------------------------

c-vars can be interpolated within the TMF, using a construct delimited by
'/'. This can take on of three forms:

 /<modename>/
 	interpolate the value of this c-var for another mode
 /<modename>:<variablename>/
 	interpolate the value of an arbitrary c-var for an arbitrary mode
 /:<variablename>/
 	interpolate the value of an arbitrary c-var in this mode

<modename> can by the '^' character, to mean "the basemode of the current
mode", and the '@' character, to mean "the current mode". Otherwise, it
should be a valid mode name starting with an alphabetical character.

Invalid /.../ interpolations should be avoided; Zap will try reasonably hard
to simply discard them, but can get confused at boundary conditions. If you
need to escape a character, use the '\' character (so "\\" is interpreted
as '\', and "\/" is interpreted as '/').

The TMF for a given mode, MyMode, is found by looking up the system variable
Zap$TMF_MyMode. Typically this will be set in the extension's !Setup file.
Note also that it can be useful to internationalise TMFs (currently this
isn't very useful, but in the future soft wrap and word delimiter characters
will be set in the TMFs, both of which certainly should be
language-dependent).

Internationalising your extension
---------------------------------

As of v1.45, Zap supports internationalisation - ie language- and
country-specific resources may be translated. The following support is
provided for extensions to have international support.

Zap itself will set up a system variable, Zap$Country, giving the current
country required. Each extension should have a directory for each country it
supports; country-independent resources should remain directly in the
extension's application directory. You should insure that there is either a
UK, or a country-independent, version of every file your extension needs.

Some files are located automatically by Zap (HelpData, Keys, Messages and
Types files); some you will need to find yourself. A suggested way of doing
this is mentioned below, where we discuss the !Setup file.

Messages files provide a way of using country-specific strings instead of
fixed strings for menus, colour names, prompts, errors and so on. See
E-ZapCalls for details of the calls you can use for token lookup.

HelpData, Menus, Messages, Sprites and Templates are frequently
country-specific. Types, Scripts, TMFs and Keys file are usually
country-independent, although if any contain country- or language- dependent
strings (typically strings that aren't either fixed by the Zap command
language, or fixed by a file format) then they should be moved into
country-specific directories.

All distribution extensions have international support, although many only
have UK country directories.

The !Setup file
---------------

The !Setup file is where you set up anything that will be needed by the time
your extension is loaded by Zap, but isn't needed previously. They are typed
Obey (&FEB).

A typical !Setup file looks like:

---8<-------------------------------------------------
| !Setup file for MyMode

Set ZapMyMode$Dir <Obey$Dir>
Set ZapMyMode$Path <ZapMyMode$Dir>.<Zap$Country>.,<ZapMyMode$Dir>.UK.,<ZapMyMode$Dir>.
Set ZapMyMode$Scripts ZapMyMode:Scripts
Set ZapMyMode$Sprites ZapMyMode:Sprites
Set ZapMyMode$Menus ZapMyMode:Menus
Set ZapMyMode$Templates ZapMyMode:Templates
Set Zap$TMF_MyMode ZapMyMode:TMF
---8<-------------------------------------------------

You should, in general, use the path (which searches for the current
country's localised version of a file, then the UK version, and then a
country-independent version) rather than the directory (which will only find
the country-independent version) when loading files. It has become customary
to use a system variable for anything loaded from within the extension
itself, to provide a degree more flexibility.

Button bars for your mode
-------------------------

If you wish to add a button bar to your mode (such as currently available in
Email, BASIC and several others), you will need to use the features supplied
by the ZapButtons extension. For more information, see the documentation
which comes with it.

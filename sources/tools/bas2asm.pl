#!/usr/bin/perl -w
#
# bas2asm
#
# Convert BBC BASIC ARM assembler to objasm/armasm format
# Author: James Aylett
# (c) Zap Developers 2001
#
# More or less intended as a better replacement for BasToAsm that
# Dominic wrote ages ago: one which doesn't barf on Tim's modes.
#
# This isn't perfect. You should really visually inspect the output.
# You certainly have to in the case of functions ...

use strict;
use Getopt::Long;
use POSIX;

sub strip_space($)
{
  my ($f) = @_;
  $f =~ s/^\s*(.*?)\s*$/$1/;
  return $f;
}

sub split_labels($)
{
  my ($l) = @_;
  my @chars = split //, $l;
  my ($i, $quote);
  my @labels = ();
  my $label = "";
  for ($i=0, $quote=""; $i<scalar @chars; $i++) {
    if ($quote ne "") {
      if ($chars[$i] eq $quote) {
	if ($i+1 < scalar @chars && $chars[$i+1] eq $quote) {
	  $label .= $chars[$i];
	  $i++;
	} else {
	  $quote="";
	  $label .= $chars[$i];
	}
      } else {
	$label .= $chars[$i];
      }
    } elsif ($chars[$i] eq '"') {
      $quote = $chars[$i];
      $label .= $chars[$i];
    } elsif ($chars[$i] eq '-') {
      push @labels, strip_space($label);
      push @labels, '-';
      $label = "";
    } elsif ($chars[$i] eq '+') {
      push @labels, strip_space($label);
      push @labels, '+';
      $label = "";
    } else {
      $label .= $chars[$i];
    }
  }
  push @labels, strip_space($label);
  return @labels;
}

sub transform_label($%$)
{
  my ($label, $ref_labels, $linenumber) = @_;
  if (!defined $label) { return $label; }
  $label = strip_space($label);

  my @labels = ();
  my $context = 'number';
  
  if ($label =~ m/^[-+]/) {
    push @labels, $label;
  } else {
    @labels = split_labels($label);
  }
  my $output = "";
  my $i = 0;
  foreach $label (@labels) {
    $label = strip_space($label);
    if ($i) {
      # operator
      if ($context ne 'string' or $label ne '+') {
	$output .= " $label ";
      } else {
	$output .= ", ";
      }
    } else {
      # label
      my $lret; 
      ($lret, $context) = transform_individual_label($label, $ref_labels, $linenumber);
      $output .= $lret;
    }
    $i = 1 - $i;
  }
  return $output;
}

sub transform_individual_label($%$)
{
  my ($label, $ref_labels, $linenumber) = @_;
  my $flag = ($label =~ s/^\((.*)\)$/$1/);
  my $context = 'number';
  if ($label =~ m/^[-0-9&]/) {
    if ($label =~ s/^&//) {
      $label = "0x" . $label;
    }
  } elsif ($label !~ m#^"#) {
    # ie: symbolic constant
#    warn "looking up '$label'\n";
    if ($$ref_labels{$label}) {
      $label = $$ref_labels{$label};
    } else {
#      warn "transform_individual_label('$label')\n";
      if ($label =~ s/^CHR\$(\s*)([0-9A-Fa-f]+)$/$2/) {
	$context = 'string';
      } else {
	warn "Ref to undef '$label' (pre-defined constant?) at line $linenumber\n";
      }
    }
  } else {
    # ie: string constant
    $context = 'string';
  }
#  print "\n";
  if ($flag) {
    $label = "($label)";
  }
  return ($label, $context);
}

sub transform_swi($$)
{
  my ($swi, $linenumber) = @_;
  if (!defined $swi) { return $swi; }
  $swi = strip_space($swi);
  if ($swi =~ m/^[-0-9&]/) {
    if ($swi =~ m/^&/) {
      $swi = "0x" . substr($swi, 1);
    }
  } elsif ($swi =~ m#^"#) {
    $swi =~ s#^"(.*)"$#$1#;
  } else {
    warn "Invalid SWI name/number '$swi' (assuming constant) at line $linenumber\n";
  }
  return $swi;
}

sub transform_reg($)
{
  # can have '!' if a post-increment register, or if
  # a base register for STM|LDM
  my ($reg) = @_;
  $reg = strip_space($reg);
  if ($reg =~ m/^[0-9a-f]/i) {
    # register in numeric only form
    $reg = 'r' . $reg;
    $reg =~ s/A/10/i;
    $reg =~ s/B/11/i;
    $reg =~ s/C/12/i;
    $reg =~ s/D/13/i;
    $reg =~ s/E/14/i;
    $reg =~ s/F/15/i;
  }
  $reg =~ tr/RPC/rpc/; # Rn -> rn and PC -> pc
  $reg =~ s/r15/pc/;
  $reg =~ s/r14/lr/;
  $reg =~ s/r13/sp/;
  $reg =~ s/\s*!/!/;
  return $reg;
}

# Turns [...] and {...} into one operand. Respects "-quotes, with doubling
# to provide quote character (converted to \" in output). Embedded NULs
# in a string get the string turned into "...", 0, "...", which
# isn't pretty but at least should work.
sub split_operands($)
{
  my ($line) = @_;
  my @chars = split '', $line;
  my ($i, $inquote, $inquote_double);
#  warn "split_operands('$line'), " . scalar @chars . "\n";
  $line="";
  my @out = ();
  $inquote="";
  $inquote_double = 0;
  for ($i=0; $i<scalar @chars; $i++) {
    if ($inquote) {
      if ($chars[$i] eq $inquote and $inquote ne "") {
	if ($inquote_double and $i+1<scalar @chars and $chars[$i+1] eq $inquote) {
#	  warn " * Doubled quote '$inquote' at $i.\n";
	  $line .= '\\';
#	  $i++; # skip over the quoting one -- fails ???
	} else {
#	  warn " * Leaving quote '$inquote' at $i.\n";
	  $inquote="";
	  $inquote_double = 0;
	}
      }
      if ($chars[$i] =~ m/\x00/) {
	# embedded NUL! Eek!
#	$line .= "\":CC::CHR:0:CC:\"";
	$line .= "\", 0, \"";
      } elsif ($chars[$i] =~ m/\\/) {
	$line .= '\\\\'; # double up the quote character
      } else {
	$line .= $chars[$i];
      }
    } else {
      if ($chars[$i] eq ",") {
	$line = strip_space($line);
	push @out, $line;
	$line="";
      } elsif ($chars[$i] eq "{") {
	$inquote = "}";
        $inquote_double = 0;
#	warn " * Gone into quote '$inquote' at $i.\n";
	$line .= $chars[$i];
      } elsif ($chars[$i] eq "[") {
	$inquote = "]";
        $inquote_double = 0;
#	warn " * Gone into quote '$inquote' at $i.\n";
	$line .= $chars[$i];
      } elsif ($chars[$i] eq '"') {
	$inquote = '"';
        $inquote_double = 1;
#	warn " * Gone into quote '$inquote' at $i.\n";
	$line .= $chars[$i];
      } else {
	$line .= $chars[$i];
      }
    }
  }
  if ($inquote) {
    warn "Unclosed '$inquote' bracket in operand: fixing\n";
    $line .= $inquote;
  }
  if ($line ne "") {
    $line = strip_space($line);
    push @out, $line;
  }
  return @out;
}

# Pass one: separate into (label,command,comment) array.
# Pass two: fix up labels.
# Pass three: convert commands.

my $infile = shift;
my $outfile = shift;
my $getfile;
$getfile = shift or $getfile = "";

open INFILE, $infile or die "Couldn't open $infile: $!";

my (@sourcelines, $line);
@sourcelines = ();

while ($line=<INFILE>) {
  chomp $line;
  $line =~ s/^\s*REM(.*)$/; $1/;
  push @sourcelines, $line;
}
close INFILE;

my @objects = (); # hashref (Type=>(Label,Command,Comment), SourceLine=>, SourceText=>, AsmText=>)

# scan into @objects
my $sourceline = 0;
foreach $line (@sourcelines) {
  $sourceline++;
#  print "Considering '$line', line $sourceline.\n";
  $line =~ s/^\s*//; # strip leading WSP
  if (substr($line, 0, 1) eq '.') {
    my @bits = split ':|[\t ]+', substr($line, 1), 2; # separate label from rest of line
    if (defined $bits[1]) {
#      print "Split line '$line' at label to get '$bits[0]' and '$bits[1]'\n";
    } else {
#      print "Split line '$line' at label to get '$bits[0]'\n";
    }
    my %object = ();
    $object{'Type'}='Label';
    $object{'SourceText'}=$bits[0]; # doesn't include '.'
    $object{'SourceLine'}=$sourceline;
#    print "Pushed label at line $sourceline '$bits[0]'\n";
    push @objects, \%object;
    $line = $bits[1];
  }
  # Now we must split around ':' (as many as we find) and ';' (once only, and
  # terminating ':'-splitting) outside "-strings
  if (defined $line and $line ne "") {
    my (@chars, $inquote, $i);
    @chars = split //, $line;
    $inquote = 0;
    $line = "";
    for ($i=0; $i<scalar(@chars); $i++) {
      if ($inquote) {
        if ($chars[$i] eq $inquote) {
          if ($i+1<scalar(@chars) and $chars[$i+1] eq $inquote) { # quoted quote delimiter
            $i++;
          } else {
            $inquote = 0;
#            print "Exiting quote at line $sourceline.\n";
          }
        }
        $line .= $chars[$i];
      } else {
        if ($chars[$i] eq '"') {
#          print "Entering quote at line $sourceline.\n";
          $inquote = $chars[$i];
          $line .= $chars[$i];
        } elsif ($chars[$i] eq ':') {
          # push a new command
          my %object = ();
          $object{'Type'} = 'Command';
          $object{'SourceText'} = $line;
          $object{'SourceLine'}=$sourceline;
	  push @objects, \%object;
#          print "Pushed command at line $sourceline: '$line'\n";
          $line = "";
        } elsif ($chars[$i] eq ';') {
          # push the command we've ended, plus a comment to end of line
          my %object = ();
          $object{'Type'} = 'Command';
          $object{'SourceText'} = $line;
          $object{'SourceLine'}=$sourceline;
          push @objects, \%object;
#          print "Pushed command at line $sourceline: '$line'\n";
          $line = "";
  
          splice @chars, 0, $i+1; # remove everything up to and including the ';'
          my %object2 = ();
          $object2{'Type'} = 'Comment';
          $object2{'SourceText'} = join "", @chars;
          $object2{'SourceLine'}=$sourceline;
#          print "Pushed comment at line $sourceline: '$object2{'SourceText'}'\n";
          push @objects, \%object2;
          $i = scalar(@chars);
        } else {
          $line .= $chars[$i];
        }
      }
    }
    if ($line) {
      if ($inquote) {
        warn "Fixing up open quote at line $sourceline\n";
        $line .= $inquote;
      }
      my %object = ();
      $object{'Type'} = 'Command';
      $object{'SourceText'} = $line;
      $object{'SourceLine'}=$sourceline;
#      print "Pushed command at line $sourceline: '$line'\n";
      push @objects, \%object;
    }
  }
}

# Fix up all labels. Any time we find a clash, rename the second instance.
# %labels allows us to look up the most recent instance of a given variable.
my ($object, %labels); # <SourceText>=> AsmName
%labels = ();
my $altered_count = 0;
foreach $object (@objects) {
  if ($$object{'Type'} eq 'Label') {
    my $label = $$object{'SourceText'};
    ($label =~ m/^[0-9]/) and die "Label '$label' starts with a numeric digit. I can't cope with this (how can I tell the difference between it and a register?). Please fix this before running me again!";
    $label =~ tr/$%//d; # Get rid of valid BASIC variable chars that we don't want
    if (($label =~ m/^_altered_/) or defined $labels{$$object{'SourceText'}}) {
      # eek, it's already in there! (or clashes with our reserved namespace)
      $label = "_altered_${altered_count}";
      if ($$object{'SourceText'} =~ m/^_altered_/) {
	warn "Label '$$object{'SourceText'}' is reserved (changed to '$label') at line $$object{'SourceLine'}\n";
      } else {
	warn "Label '$$object{'SourceText'}' already defined (changed to '$label') at line $$object{'SourceLine'}\n";
      }
      $altered_count++;
    }
    $labels{$$object{'SourceText'}} = $label;
    $$object{'AsmText'} = $label;
  }
}

# fixup AsmText entries in @objects
# don't reset %labels: BASIC works multi-pass to set them up, so so must we
my %functions = ();
my %functions_done = ();
foreach $object (@objects) {
#  warn "$$object{'Type'} from $$object{'SourceLine'}";
  if ($$object{'Type'} eq 'Label') {
    $labels{$$object{'SourceText'}} = $$object{'AsmText'};
  } elsif ($$object{'Type'} eq 'Comment') {
    $$object{'AsmText'} = $$object{'SourceText'};
    $$object{'AsmText'} =~ s/\0//g;
  } elsif ($$object{'Type'} eq 'Command') {
    # Method (depending on type: Fn/Asm/Directive):
    #
    #  * Functions: rewrite to a new type 'Function'. The output
    #    system can write a FIXME comment to flag it.
    #    Certain functions (FNcall, FNlong_adr) we handle
    #    automatically; others are flagged to be done manually.
    #  * Directive: EQUS -> =, =,EQUB -> =, EQUW,EQUD -> DCW,DCD
    #    & -> DCD. Others, give an error until we figure them
    #    out. Everything but EQUS, rewrite if it looks like a
    #    label not a number (numbers start '&' or 0-9).
    #  * Asm:
    #    * SWI - turn strings into symbolic constants, leave numbers
    #    * B - rewrite label
    #    * everything else:
    #      1. ensure the command is capitalised
    #      2. split into operands
    #      3. first operand is ALMOST always a simple register
    #         (exceptions are things like FP and MSR, so we'll ignore
    #         them).
    #      4. second operand will be register, #<const>, label,
    #         {reg_list}, shifted/rotated register, or register offset
    #         * register -> r0-r12, sp, lr, pc. For STM|LDM,
    #           the base register can have writeback '!'.
    #         * #const retained, &-hex form -> 0x-form
    #           #ASC"something" needs coping with too ...
    #         * label rewritten
    #         * {reg_list}[^] gets register translation
    #         * shifted reg: register translation, hex form
    #           translation
    #           reg, op reg or reg, op #const or reg
    #         * rotate reg: RRX
    #         * register offset: register translation, hex
    #           form translation (and can have '!' writeback)
    #           [reg, shift]! or [reg], shift!
    #  * Rewriting labels: look up the current one
    if (substr($$object{'SourceText'}, 0, 2) eq 'FN') {
      my $fn_name = strip_space($$object{'SourceText'});
      my $params = $fn_name;
      $fn_name =~ s/^FN(.*?)\((.*)\)$/$1/;
      $params =~ s/^FN(.*?)\((.*)\)$/$2/;
      $params = strip_space($params);
      # Now we look for some functions we understand already ...
      if ($fn_name eq 'call') {
	# One parameter ...
	$$object{'AsmText'} = "FNcall\t$params";
	$functions_done{$fn_name}++;
      } elsif ($fn_name eq 'jump') {
	# One parameter ...
	$$object{'AsmText'} = "FNjump\t$params";
	$functions_done{$fn_name}++;
      } elsif ($fn_name eq 'lower') {
	# One parameter
	$$object{'AsmText'} = "FNlower\t" . transform_reg(strip_space($params));
	$functions_done{$fn_name}++;
      } elsif ($fn_name eq 'upper') {
	# One parameter
	$$object{'AsmText'} = "FNupper\t" . transform_reg(strip_space($params));
	$functions_done{$fn_name}++;
      } elsif ($fn_name eq 'long_adr') {
	# Three parameters (condition, register, label)
	my @params = split ',', $params;
	(scalar @params != 3) and die "FNlong_adr() called with the wrong numbers of parameters at line $$object{'SourceLine'}\n";
	my $asm = 'ADR' . strip_space(substr($params[0], 1, 2)) . 'L';
	$asm = strip_space($asm); # condition is usually "  " (not "AL")
	$asm =~ tr/a-z/A-Z/;
	$asm .= "\t" . transform_reg(strip_space($params[1])) . ", " . transform_label($params[2], \%labels, $$object{'SourceLine'});
	$$object{'AsmText'} = $asm;
	$functions_done{$fn_name}++;
      } else {
	$$object{'Type'} = 'Function';
	$$object{'AsmText'} = $$object{'SourceText'};
	$$object{'AsmText'} =~ s/^FN(.*?)\((.*)\)$/FN$1\t$2/;
	$functions{$fn_name}++;
      }
    } else { # directives and asm commands
      my $line;
#      undef $line;
      $$object{'SourceText'} = strip_space($$object{'SourceText'});
      if ($$object{'SourceText'} ne "") {
	$$object{'SourceText'} =~ s/^EQU(D|W|B)(\S)/EQU$1 $2/;
        my @bits = split ' ', $$object{'SourceText'}, 2;
#	if (scalar(@bits) == 0) {
#	  print "Splitting '$$object{'SourceText'}' ... ";
#	  print "got " . scalar(@bits) . " pieces.\n";
#	}
        $line = $bits[0];
        $line =~ tr/a-z/A-Z/;

        my @args = ();
        if (defined $bits[1]) {
	  # split with [], {} ...
#	  warn "Splitting operands for line $$object{'SourceLine'}";
	  @args = split_operands($bits[1]);
	}

        my ($trans_args, $done_command) = (0, 0);

	$line =~ m/^(EQUD|DCD)$/i and do {
	  $line = 'DCD'; $trans_args=1; $done_command = 1;
	  $$object{'Type'} = 'Directive';
	};
	$line =~ m/^(EQUW|DCW)$/i and do {
	  $line = 'DCW'; $trans_args=1; $done_command = 1;
	  $$object{'Type'} = 'Directive';
	};
	$line =~ m/^&$/ and do {
	  $line = 'DCD'; $trans_args=1; $done_command = 1;
	  $$object{'Type'} = 'Directive';
	};
	$line =~ m/^(EQUB|DCB)$/i and do {
	  $line = '='; $trans_args=1; $done_command = 1;
	  $$object{'Type'} = 'Directive';
	};
	$line =~ m/^EQUS$/i and do {
	  $line = '='; $trans_args=1; $done_command = 1;
	  $$object{'Type'} = 'Directive';
	};
	($line =~ m/^B(L?)(EQ|NE|AL|NV|CC|CS|VC|VS|GT|GE|LT|LE|PL|MI|HI|LS|HS|LO)?$/i) and do {
	  $trans_args=1; $done_command = 1;
	};
	$line =~ m/^SWI/i and do {
	  scalar(@args)==1 or die "Invalid SWI command at line $$object{'SourceLine'}";
	  $args[0] = transform_swi($args[0], $$object{'SourceLine'});
	  $done_command = 1;
	};

	if ($done_command) {
	  if ($$object{'Type'} eq 'Directive') {
	    $$object{'DirectiveType'} = $line;
	    $$object{'CommandNotPresent'} = 'yes';
	    $line="";
	  }
	  if ($trans_args) {
	    # probably better called $trans_directive_args ...
	    my $i;
	    for ($i=0; $i<scalar(@args); $i++) {
	      $args[$i] = transform_label(strip_space($args[$i]), \%labels, $$object{'SourceLine'});
	    }
	  }
	} else {
	  # Otherwise, we still have some work to do ...
	  my $i;
	  for ($i=0; $i<scalar(@args); $i++) {
	    if ($args[$i] =~ m/^r?([0-9a-f]+|pc)(\s*!)?$/i) {
	      # register
	      $args[$i] = transform_reg($args[$i]);
	    } elsif ($args[$i] =~ m/^#/) {
	      # numeric constant (can have '!' at end if a post-offset constant)
              $args[$i] =~ s/^#(\s*)(.*)$/$2/;
              ($args[$i] =~ s/^&//) and $args[$i] = "0x$args[$i]";
#	      $args[$i] =~ s/^ASC(\s*)"(\\)?(.).*"(.*)$/'$3'/i;
	      my $asc_trap = $args[$i];
	      if ($asc_trap =~ s/^ASC(\s*)"(\\)?(.).*"(.*)$/$3/i) {
		# $asc_trap is a single character. If printable, we want
		# '$asc_trap'. Otherwise we want the decimal value.
		if (isprint($asc_trap)) {
		  $args[$i] = "'$asc_trap'";
		} else {
		  $args[$i] = ord($asc_trap);
		}
	      }
	      $args[$i] = "#$args[$i]";
	    } elsif ($args[$i] =~ m/^{/) {
	      # register range
	      # form is '{' (reg '-' reg | reg) (',' (reg '-' reg | reg))* '}' '^'?
	      my $flag = ($args[$i] =~ m/\^$/);
	      $args[$i] =~ s/^{(.*)}(\s*)(\^)?$/$1/;
	      my @reg_list = split ',', $args[$i];
#	      warn "Register range: $args[$i]";
	      my $reg;
	      $args[$i] = "{";
	      foreach $reg (@reg_list) {
		if ($reg =~ m/-/) {
		  my @regs = split '-', $reg, 2;
		  foreach $reg (@regs) {
		    $args[$i] .= transform_reg($reg) . "-";
		  }
		  $args[$i] =~ s/-$/, /;
		} else {
		  $args[$i] .= transform_reg($reg) . ", ";
		}
	      }
	      $args[$i] =~ s/, $/}/;
              if ($flag) { $args[$i] .= '^'; }
	    } elsif ($args[$i] =~ m/^\[/) {
	      # register offset
	      # form is '[' reg (',' (reg | '#' const))? ']' '!'?
	      my $flag = ($args[$i] =~ m/!$/);
	      $args[$i] =~ s/^\[(.*)\](\s*)(!)?$/$1/;
	      my @reg_list = split ',', $args[$i], 2;
#	      warn "Register offset: $args[$i]";
	      $args[$i] = "[";
	      $args[$i] .= transform_reg($reg_list[0]);
	      if (defined $reg_list[1]) {
		$reg_list[1] = strip_space($reg_list[1]);
		if ($reg_list[1] ne "") {
		  $args[$i] .= ", ";
		  if ($reg_list[1] =~ m/^#/) {
		    # constant
		    my $const = $reg_list[1];
		    $const =~ s/^#(\s*)(.*)$/$2/;
		    ($const =~ s/^&//) and $const = "0x$const";
		    $const =~ s/^ASC(\s*)"(\\)?(.).*"(.*)$/'$2'/i;
		    $args[$i] .= "#$const";
		  } else {
		    # register
		    $args[$i] .= transform_reg($reg_list[1]);
		  }
		}
	      }
	      $args[$i] .= "]";
	      if ($flag) { $args[$i] .= "!"; }
	    } elsif ($args[$i] =~ m/^(ASL|ASR|LSR|LSL|ROR)/i) {
	      # shift (followed by #constant or register)
	      my @bits;
	      $bits[0] = substr($args[$i], 0, 3);
	      $bits[1] = strip_space(substr($args[$i], 3));
	      $bits[0] =~ tr/a-z/A-Z/; # capitalise shift operator
	      if ($bits[1] =~ m/^#/) {
	        # constant
		my $const = $bits[1];
		$const =~ s/^#(\s*)(.*)$/$2/;
		($const =~ s/^&//) and $const = "0x$const";
		$const =~ s/^ASC(\s*)"(\\)?(.).*"(.*)$/'$2'/i;
		$bits[1] = "#$const";
	      } else {
		# register
		$bits[1] = transform_reg($bits[1]);
	      }
	      $args[$i] = $bits[0] . ' ' . $bits[1];
	    } elsif ($args[$i] =~ m/^RRX/i) {
	      # rotate extended shift (no arguments)
	      ($args[$i] =~ m/^RRX$/i) or die "RRX had something after it ... ?";
	      $args[$i] =~ tr/a-z/A-Z/; # capitalise shift operator
	    } else {
	      # label
	      $args[$i] = transform_label($args[$i], \%labels, $$object{'SourceLine'});
	    }
	  }
	}

	if (scalar(@args) > 0) {
	  if (!defined $$object{'CommandNotPresent'}) {
	    $line .= "\t";
	  }
	  my ($arg, $flag);
	  $flag = 1;
	  foreach $arg (@args) {
	    if ($arg ne "") {
	      if (!$flag) {
		$line .= ", ";
	      } else {
		$flag = 0;
	      }
	      $line .= strip_space($arg);
	    }
	  }
	}
      } else {
	$line = "";
      }
      $$object{'AsmText'} = $line;
    }
  }
}

my %object = (Type=>'EndOfFile');
push @objects, \%object;

if (scalar keys %functions) {
  warn "Found the following functions (marked FIXME in output):\n";
  foreach $object (keys %functions) {
    warn "\tFN$object() ($functions{$object})\n";
  }
}

if (scalar keys %functions_done) {
  warn "Translated the following functions:\n";
  foreach $object (keys %functions_done) {
    warn "\tFN$object() ($functions_done{$object})\n";
  }
}

# write out
open OUTFILE, ">$outfile" or die "Couldn't open $outfile: $!";

print OUTFILE "; $outfile\n";
print OUTFILE "; converted from $infile by bas2asm.pl\n";

if ($getfile ne "") {
  print OUTFILE "\tGET\t$getfile\n";
}

my $last_type = '';
my $i;
for ($i=0; $i<scalar(@objects); $i++) {
  my $object = $objects[$i];

  $$object{'Type'} eq 'Function' and do {
    print OUTFILE "\n\t$$object{'AsmText'}\t; FIXME: function";
  };
  $$object{'Type'} eq 'Directive' and do {
    my $dtype = $$object{'DirectiveType'};
    my $j = 0;
    if ($dtype eq '=') {
      do {
	$object = $objects[$i+ ++$j];
      } while ($$object{'Type'} eq 'Directive' and $$object{'DirectiveType'} eq $dtype);
    } else {
      $j=1;
    }
    $object = $objects[$i];
    print OUTFILE "\n\t$$object{'DirectiveType'}\t";
    my $first=1;
    for (; $j>0; $i++, $j--) {
      $object = $objects[$i];
      if ($first) {
	$first=0;
      } else {
	print OUTFILE ", ";
      }
      print OUTFILE $$object{'AsmText'};
    }
    $i--; # went one too far ($j -> 0 in loop above)
  };
  $$object{'Type'} eq 'Comment' and do {
    if ($last_type eq 'Comment') { print OUTFILE "\n"; }
    print OUTFILE "\t; $$object{'AsmText'}";
  };
  $$object{'Type'} eq 'Label' and do {
    print OUTFILE "\n$$object{'AsmText'}";
  };
  $$object{'Type'} eq 'Command' and do {
    print OUTFILE "\n\t$$object{'AsmText'}";
  };
  $last_type = $$object{'Type'};
}
print OUTFILE "\n\n\tEND\n";
close OUTFILE;

warn "\n---------------------------------------------------------------------------\nYou should now verify the output file '$outfile', fixing up functions and\ngenerally ensuring that the output is correct.\n---------------------------------------------------------------------------\n";

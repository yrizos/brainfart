#Brainfart

An over-engineered Brainfuck intepreter, written in PHP.

##Supported syntax

Brainfart supports the typical [Brainfuck commands](http://en.wikipedia.org/wiki/Brainfuck#Commands "Brainfuck commands on Wikipedia"):

	>   increment the data pointer (to point to the next cell to the right).
	<   decrement the data pointer (to point to the next cell to the left).
	+   increment (increase by one) the byte at the data pointer.
	-   decrement (decrease by one) the byte at the data pointer.
	.   output the byte at the data pointer.
	,   accept one byte of input, storing its value in the byte at the data pointer.
	[   if the byte at the data pointer is zero, then instead of moving the instruction pointer forward to the next command, jump it forward to the command after the matching ] command.
	]   if the byte at the data pointer is nonzero, then instead of moving the instruction pointer forward to the next command, jump it back to the command after the matching [ command.

...plus [Toadskin](http://esolangs.org/wiki/Toadskin "Toadskin is a minimal esoteric programming language based on combining aspects of brainfuck and Forth.") inspired named sequences. This:

	:MB5-----; :MF5+++++;

	MF5 MF5             initialize counter (cell #0) to 10
	[                       use loop to set the next four cells to 70/100/30/10
	    > MF5 ++              add  7 to cell #1
	    > MF5 MF5           add 10 to cell #2
	    > +++                   add  3 to cell #3
	    > +                     add  1 to cell #4
	    <<<< -                  decrement counter (cell #0)
	]
	> ++ .                  print 'H'
	> + .                   print 'e'
	MF5 ++ .                print 'l'
	.                       print 'l'
	+++ .                   print 'o'
	> ++ .                  print ' '
	<< MF5 MF5 MF5 .        print 'W'
	> .                     print 'o'
	+++ .                   print 'r'
	Mb5 - .                 print 'l'
	Mb5 --- .               print 'd'
	> + .                   print '!'
	> .                     print '\n'

will generate this:

    ++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.

Non supported characters are ignored.

##Peephole optimization

Consecutive similar data pointer commands are grouped. This script:

    +++++

Will be interpreted as a single command that increases the byte at the data pointer by 5. The same for `-`, `>` and `<`.

##Bugs

There probably are a few. Meh.
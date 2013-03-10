#Brainfart

Brainfart is an over-engineered [Brainfuck interpreter](http://esolangs.org/wiki/Brainfuck), written in PHP.

It's a weekend pet project, nowhere near complete and slow as hell (by design). 

##Syntax

**Memory operations**

- `>` Moves the memory pointer to the right.
- `<` Moves the memory pointer to the left.
- `+` Increments the byte at the memory pointer by one.
- `-` Decrements the byte at the memory pointer by one.

**Input / Output operations**

- `.` Outputs the byte at the memory pointer.
- `,` Accepts one byte of input and stores it at the memory pointer.

**Loops**

`[` If the byte at the memory pointer is zero, jump to the command after the matching `]`.

**Named sequences**

`:<alpha><brainfuck>;` will replace occurrences of `<alpha>` with `<brainfuck>`. 

    mf5mf5[>mf5++>mf5mf5>+++>+<<<<-]>++.>+.mf5++..+++.>++.<<mf5mf5mf5.>.+++.mb3mb3.mb3mb3--.>+.>.:mf5+++++;:mb3---; 

Will output: `Hello World!\n` (hopefully)

**Interpreter instructions** 

`!!` separates input from commands. If present, whatever is left of it will be interpreted as comma separated input.

    5,10,15,20!!>>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]

`@@` will turn off peephole optimization. This may or may not weaken performance.

`$$` will force a string output, instead of the default array.

**Misc**

- `~` Sleep for as many seconds as the value of the byte at the memory pointer. This will definitely weaken performance.

##Design

**Peephole optimization** 

Consecutive similar memory pointer commands will be grouped. `+++++` will be interpreted as a single command that increments the byte at the memory pointer by five.    

This may or may not improve performance. 

**Bugs**

There are probably a ton of bugs. They are all intentional, to make coding in Brainfart a bit more challenging and fun. `</lie>`

##Boring

**License**

Brainfart is licensed under the [WTFPL](http://www.wtfpl.net/), see `license` for the full text.

**Requirements**

- PHP 5.4+
- [Composer](http://getcomposer.org/) [optional]
- [PHPUnit 3.7+](http://www.phpunit.de/manual/current/en/) [optional]
- [Phing 2.4+](http://www.phing.info/) [optional]


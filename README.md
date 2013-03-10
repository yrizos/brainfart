#Brainfart

Brainfart is an over-engineered [Brainfuck interpreter](http://esolangs.org/wiki/Brainfuck), written in PHP. It's a weekend pet project, nowhere near complete and slow as hell (by design).

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

Will output: `Hello World!\n`

##Design

**Peephole optimization** 

Consecutive similar memory pointer commands will be grouped. `+++++` will be interpreted as a single command that increments the byte at the memory pointer by five.    

**Bugs**

There are probably a ton of bugs. They are all intentional, to make coding in Brainfart a bit more challenging and fun. `</lie>`

##Boring

Brainfart is licensed under the [WTFPL](http://www.wtfpl.net/), see `LICENSE.txt` for the full text of the license.

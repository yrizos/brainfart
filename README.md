# Brainfart [![Build Status](https://travis-ci.org/yrizos/brainfart.svg?branch=master)](https://travis-ci.org/yrizos/brainfart)


Brainfart is [Brainfuck interpreter](http://esolangs.org/wiki/Brainfuck), in PHP. 

Try it out: 

    ./bin/brainfart ./tests/scripts/sort.bf "100 5 99 200" 

## Syntax

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

## Design

**Peephole optimization** 

Consecutive similar memory pointer commands will be grouped. `+++++` will be interpreted as a single command that increments the byte at the memory pointer by five.    

This may or may not improve performance. 

**Bugs**

There are probably a ton of bugs. They are all intentional, to make coding in Brainfart a bit more challenging and fun. `</lie>`
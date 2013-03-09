<?php

use Brainfart\VM\VM;
use Brainfart\VM\Output;
use Brainfart\Operations\LoopOperation;
use Brainfart\Operations\InputOperation;
use Brainfart\Operations\OutputOperation;
use Brainfart\Operations\MoveOperation;
use Brainfart\Operations\ChangeOperation;
use Brainfart\Operations\SleepOperation;

class OperationsTest extends PHPUnit_Framework_TestCase
{

    public function testIOOperation() {
        $vm = new VM("Hello world!", 10);

        $ops = array(
            new InputOperation(),
            new MoveOperation(1),
            new InputOperation(),
            new MoveOperation(1),
            new InputOperation(),
            new MoveOperation(1),
            new InputOperation(),
            new MoveOperation(1),
            new InputOperation(),
            new MoveOperation(1),
            new MoveOperation(-5),
            new OutputOperation(),
            new MoveOperation(1),
            new OutputOperation(),
            new MoveOperation(1),
            new OutputOperation(),
            new MoveOperation(1),
            new OutputOperation(),
            new MoveOperation(1),
            new OutputOperation(),
        );

        $op = new LoopOperation($ops, true);
        $op->execute($vm);

        $output = $vm->getOutput()->fetch(Output::FETCH_STRING);

        $this->assertEquals("Hello", $output);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testLoopLimitOperation() {
        $vm = new VM("Hello world!", 5);

        $ops = array(
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
        );

        $change = new ChangeOperation(1);
        $change->execute($vm);

        $loop = new LoopOperation($ops);
        $loop->execute($vm);
    }

    public function testSleepOperation() {
        $vm = new VM("Hello world!", 5);

        $sleep = new SleepOperation();
        $sleep->execute($vm);
    }

}

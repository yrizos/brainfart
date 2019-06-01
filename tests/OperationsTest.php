<?php declare(strict_types=1);

namespace Brainfart;

use Brainfart\Operations\ChangeOperation;
use Brainfart\Operations\InputOperation;
use Brainfart\Operations\LoopOperation;
use Brainfart\Operations\MoveOperation;
use Brainfart\Operations\OutputOperation;
use Brainfart\Operations\SleepOperation;
use Brainfart\VM\Output;
use Brainfart\VM\VM;

class OperationsTest extends PHPUnit_Framework_TestCase
{
    public function testIOOperation(): void
    {
        $vm = new VM('Hello world!', 10);

        $ops = [
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
        ];

        $op = new LoopOperation($ops, true);
        $op->execute($vm);

        $output = $vm->getOutput()->fetch(Output::FETCH_STRING);

        $this->assertSame('Hello', $output);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testLoopLimitOperation(): void
    {
        $vm = new VM('Hello world!', 5);

        $ops = [
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
            new InputOperation(),
        ];

        $change = new ChangeOperation(1);
        $change->execute($vm);

        $loop = new LoopOperation($ops);
        $loop->execute($vm);
    }

    public function testSleepOperation(): void
    {
        $vm = new VM('Hello world!', 5);

        $sleep = new SleepOperation();
        $sleep->execute($vm);
    }
}

<?php declare(strict_types = 1);

use Brainfart\VM\Input;
use Brainfart\VM\Memory;
use Brainfart\VM\Output;
use Brainfart\VM\VM;
use PHPUnit\Framework\TestCase;

class VMTest extends TestCase
{
    public function testInput(): void
    {
        $text  = 'Hello world!';
        $input = new Input($text);

        $text = str_split($text);
        $text = array_map('ord', $text);

        foreach ($text as $character) {
            $this->assertSame($character, $input->fetch());
        }

        $this->assertSame(0, $input->fetch());
    }

    public function testMemory(): void
    {
        $memory = new Memory();

        $this->assertSame(0, $memory->fetch());

        $memory->store(10);
        $this->assertSame(10, $memory->fetch());

        $memory->move(1);
        $this->assertSame(0, $memory->fetch());

        $memory->move(-1);
        $this->assertSame(10, $memory->fetch());
    }

    public function testOutput(): void
    {
        $text   = 'Hello world!';
        $input  = new Input($text);
        $output = new Output();

        while ($character = $input->fetch()) {
            $output->store($character);
        }

        $this->assertSame($text, $output->fetch(Output::FETCH_STRING));

        $text  = str_split($text);
        $text  = array_map('ord', $text);
        $array = $output->fetch(Output::FETCH_ARRAY);

        foreach ($text as $key => $character) {
            $this->assertSame($character, $array[$key]);
        }
    }

    public function testVM(): void
    {
        $vm = new VM('', 10);

        $this->assertInstanceOf('Brainfart\\VM\\Memory', $vm->getMemory());
        $this->assertInstanceOf('Brainfart\\VM\\Output', $vm->getOutput());
        $this->assertInstanceOf('Brainfart\\VM\\Input', $vm->getInput());
        $this->assertSame(10, $vm->getLoopLimit());
    }
}

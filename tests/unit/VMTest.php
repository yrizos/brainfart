<?php

use Brainfart\VM\VM;
use Brainfart\VM\Input;
use Brainfart\VM\Output;
use Brainfart\VM\Memory;

class VMTest extends PHPUnit_Framework_TestCase
{

    public function testInput() {
        $text  = "Hello world!";
        $input = new Input($text);

        $text  = str_split($text);
        $text  = array_map("ord", $text);

        foreach($text as $character) $this->assertEquals($character, $input->fetch());

        $this->assertEquals(0, $input->fetch());
    }

    public function testOutput() {
        $text   = "Hello world!";
        $input  = new Input($text);
        $output = new Output();

        while($character = $input->fetch()) $output->store($character);

        $this->assertEquals($text, $output->fetch(Output::FETCH_STRING));

        $text  = str_split($text);
        $text  = array_map("ord", $text);
        $array = $output->fetch(Output::FETCH_ARRAY);

        foreach($text as $key => $character) $this->assertEquals($character, $array[$key]);
    }

    public function testMemory() {
        $memory = new Memory();

        $this->assertEquals(0, $memory->fetch());

        $memory->store(10);
        $this->assertEquals(10, $memory->fetch());

        $memory->move(1);
        $this->assertEquals(0, $memory->fetch());

        $memory->move(-1);
        $this->assertEquals(10, $memory->fetch());
    }

    public function testVM() {
        $vm = new VM("", 10);

        $this->assertInstanceOf("Brainfart\\VM\\Memory", $vm->getMemory());
        $this->assertInstanceOf("Brainfart\\VM\\Output", $vm->getOutput());
        $this->assertInstanceOf("Brainfart\\VM\\Input", $vm->getInput());
        $this->assertEquals(10, $vm->getLoopLimit());
    }

}

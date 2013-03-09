<?php

use Brainfart\Brainfart;
use Brainfart\VM\Output;

class BrainfartTest extends PHPUnit_Framework_TestCase
{

    private $dir = "";

    protected function setUp() {
        $this->dir = realpath(__DIR__ . "/../scripts");
    }

    public function testHelloWorld() {
        $output = Brainfart::run($this->dir . "/helloworld.bf", "", Output::FETCH_STRING);

        $this->assertEquals("Hello World!\n", $output);
    }

    public function testHelloWorld_Skintoad() {
        $output = Brainfart::run($this->dir . "/helloworld.skintoad.bf", "", Output::FETCH_STRING);

        $this->assertEquals("Hello World!\n", $output);
    }

    public function testSort() {
        $length = 20;
        $input  = array();

        for ($i = 0; $i < $length; $i++) $input[] = rand(0, 100);

        $output = Brainfart::run($this->dir . "/sort.bf", $input);
        sort($input);

        $this->assertEquals($input, $output);
    }
}

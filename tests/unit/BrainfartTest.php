<?php

use Brainfart\Brainfart;
use Brainfart\VM\Output;

class BrainfartTest extends PHPUnit_Framework_TestCase
{

    private $dir = "";

    /**
     * @var Brainfart
     */
    private $bf;

    protected function setUp() {
        $this->dir = realpath(__DIR__ . "/../scripts");
        $this->bf  = new Brainfart(1000, true);
    }

    public function testHelloWorld() {
        $output = $this->bf->run($this->dir . "/helloworld.bf", "", Output::FETCH_STRING);

        $this->assertEquals("Hello World!\n", $output);
    }

    public function testHelloWorld_Sequences() {
        $output = $this->bf->run($this->dir . "/helloworld.sequences.bf", "", Output::FETCH_STRING);

        $this->assertEquals("Hello World!\n", $output);
    }

    public function testSort() {
        $input  = array(100, 2, 50, 3, 1, 20, 1, 90, 40);
        $output = $this->bf->run($this->dir . "/sort.bf", $input);
        sort($input);

        $this->assertEquals($input, $output);
    }
}

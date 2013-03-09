<?php

use Brainfart\Parser\Loader;

class LoaderTest extends PHPUnit_Framework_TestCase
{

    private $dir = "";

    protected function setUp() {
        $this->dir = realpath(__DIR__ . "/../scripts");
    }

    public function testLoadFile() {
        $loader   = new Loader("{$this->dir}/helloworld.bf");
        $expected = "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.";

        $this->assertEquals($expected, $loader->getSource());
    }

    public function testLoadString() {
        $expected = "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.";
        $source   = "+ + + + + + + + + + hello world [>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.";
        $loader   = new Loader($source);

        $this->assertEquals($expected, $loader->getSource());
    }

    public function testLoadSkinToad() {
        $loader = new Loader($this->dir . "/helloworld.skintoad.bf");

        $expected = "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.";
        $skintoad = $loader->getSource();

        $loader->loadSource($this->dir . "/../scripts/helloworld.bf");
        $original = $loader->getSource();

        $this->assertEquals($expected, $skintoad);
        $this->assertEquals($original, $skintoad);
    }
}

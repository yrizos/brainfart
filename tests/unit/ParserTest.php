<?php

use Brainfart\Parser\Loader;
use Brainfart\Parser\Parser;
use Brainfart\Operations\MoveOperation;
use Brainfart\Operations\ChangeOperation;

class ParserTest extends PHPUnit_Framework_TestCase
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

    public function testParserInput() {
        $source    = "5,10,15,20!!>>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]";
        $expInput  = array("5", "10", "15", "20");
        $expSource = ">>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]";

        $loader = new Loader($source);

        $this->assertEquals($expInput, $loader->getInput());
        $this->assertEquals($expSource, $loader->getSource());

        $source = "5 , 10 , 15 , 20 , !! >>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]";
        $loader->loadSource($source);

        $this->assertEquals($expInput, $loader->getInput());
        $this->assertEquals($expSource, $loader->getSource());
    }

    public function testLoadSkinToad() {
        $loader = new Loader($this->dir . "/helloworld.sequences.bf");

        $expected = "++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.";
        $skintoad = $loader->getSource();

        $loader->loadSource($this->dir . "/../scripts/helloworld.bf");
        $original = $loader->getSource();

        $this->assertEquals($expected, $skintoad);
        $this->assertEquals($original, $skintoad);
    }

    public function testParser_mutableOperations_unoptimized() {
        $parser     = new Parser("+++>->-<<");
        $operations = $parser->parse(false);

        $this->assertInstanceOf("Brainfart\\Operations\\LoopOperation", $operations);
        $this->assertTrue($operations->getMaster());

        $operations = $operations->getOperations();

        $expected =
            array(
                new ChangeOperation(1),
                new ChangeOperation(1),
                new ChangeOperation(1),
                new MoveOperation(1),
                new ChangeOperation(-1),
                new MoveOperation(1),
                new ChangeOperation(-1),
                new MoveOperation(-1),
                new MoveOperation(-1),
            );

        foreach ($expected as $key => $value) {
            $class = get_class($value);
            $op    = $operations[$key];

            $this->assertInstanceOf($class, $op);
            /** @noinspection PhpUndefinedMethodInspection */
            $this->assertEquals($value->getValue(), $op->getValue());
        }

    }

    public function testParser_mutableOperations_optimized() {
        $parser     = new Parser("+++++>>++++>>++<<<<-----");
        $operations = $parser->parse();

        $this->assertInstanceOf("Brainfart\\Operations\\LoopOperation", $operations);
        $this->assertTrue($operations->getMaster());

        $operations = $operations->getOperations();

        $expected =
            array(
                new ChangeOperation(5),
                new MoveOperation(2),
                new ChangeOperation(4),
                new MoveOperation(2),
                new ChangeOperation(2),
                new MoveOperation(-4),
                new ChangeOperation(-5),
            );

        foreach ($expected as $key => $value) {
            $class = get_class($value);
            $op    = $operations[$key];

            $this->assertInstanceOf($class, $op);
            /** @noinspection PhpUndefinedMethodInspection */
            $this->assertEquals($value->getValue(), $op->getValue());
        }
    }
}

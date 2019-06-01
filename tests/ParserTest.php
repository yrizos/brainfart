<?php declare(strict_types = 1);

namespace Brainfart;

use Brainfart\Operations\ChangeOperation;
use Brainfart\Operations\MoveOperation;
use Brainfart\Parser\Loader;
use Brainfart\Parser\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @var string
     */
    private $dir = '';

    protected function setUp(): void
    {
        $this->dir = realpath(__DIR__ . '/scripts');
    }

    public function testLoadFile(): void
    {
        $loader   = new Loader("{$this->dir}/helloworld.bf");
        $expected = '++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.';

        $this->assertSame($expected, $loader->getSource());
    }

    public function testLoadSkinToad(): void
    {
        $loader = new Loader($this->dir . '/helloworld.sequences.bf');

        $expected = '++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.';
        $skintoad = $loader->getSource();

        $loader->loadSource($this->dir . '/../scripts/helloworld.bf');
        $original = $loader->getSource();

        $this->assertSame($expected, $skintoad);
        $this->assertSame($original, $skintoad);
    }

    public function testLoadString(): void
    {
        $expected = '++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.';
        $source   = '+ + + + + + + + + + hello world [>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+.>.';
        $loader   = new Loader($source);

        $this->assertSame($expected, $loader->getSource());
    }

    public function testParserInput(): void
    {
        $source    = '5,10,15,20!!>>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]';
        $expInput  = ['5', '10', '15', '20'];
        $expSource = '>>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]';

        $loader = new Loader($source);

        $this->assertSame($expInput, $loader->getInput());
        $this->assertSame($expSource, $loader->getSource());

        $source = '5 , 10 , 15 , 20 , !! >>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]';
        $loader->loadSource($source);

        $this->assertSame($expInput, $loader->getInput());
        $this->assertSame($expSource, $loader->getSource());
    }

    public function testParserMutableOperationsOptimized(): void
    {
        $parser     = new Parser('+++++>>++++>>++<<<<-----');
        $operations = $parser->parse();

        $this->assertInstanceOf('Brainfart\\Operations\\LoopOperation', $operations);
        $this->assertTrue($operations->getMaster());

        $operations = $operations->getOperations();

        $expected =
            [
                new ChangeOperation(5),
                new MoveOperation(2),
                new ChangeOperation(4),
                new MoveOperation(2),
                new ChangeOperation(2),
                new MoveOperation(-4),
                new ChangeOperation(-5),
            ];

        foreach ($expected as $key => $value) {
            $class = get_class($value);
            $op    = $operations[$key];

            $this->assertInstanceOf($class, $op);
            /** @noinspection PhpUndefinedMethodInspection */
            $this->assertSame($value->getValue(), $op->getValue());
        }
    }

    public function testParserMutableOperationsUnoptimized(): void
    {
        $parser     = new Parser('+++>->-<<');
        $operations = $parser->parse(false);

        $this->assertInstanceOf('Brainfart\\Operations\\LoopOperation', $operations);
        $this->assertTrue($operations->getMaster());

        $operations = $operations->getOperations();

        $expected =
            [
                new ChangeOperation(1),
                new ChangeOperation(1),
                new ChangeOperation(1),
                new MoveOperation(1),
                new ChangeOperation(-1),
                new MoveOperation(1),
                new ChangeOperation(-1),
                new MoveOperation(-1),
                new MoveOperation(-1),
            ];

        foreach ($expected as $key => $value) {
            $class = get_class($value);
            $op    = $operations[$key];

            $this->assertInstanceOf($class, $op);
            /** @noinspection PhpUndefinedMethodInspection */
            $this->assertSame($value->getValue(), $op->getValue());
        }
    }
}

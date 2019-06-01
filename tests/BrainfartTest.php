<?php declare (strict_types = 1);

namespace Brainfart;

use Brainfart\VM\Output;
use PHPUnit\Framework\TestCase;

class BrainfartTest extends TestCase
{
    /**
     * @var Brainfart
     */
    private $bf;

    /**
     * @var string
     */
    private $dir = '';

    public function testHelloWorld(): void
    {
        $output = $this->bf->run($this->dir . '/helloworld.bf', '', Output::FETCH_STRING);

        $this->assertSame("Hello World!\n", $output);
    }

    public function testHelloWorldSequences(): void
    {
        $output = $this->bf->run($this->dir . '/helloworld.sequences.bf', '', Output::FETCH_STRING);

        $this->assertSame("Hello World!\n", $output);
    }

    public function testSort(): void
    {
        $input  = [100, 2, 50, 3, 1, 20, 1, 90, 40];
        $output = $this->bf->run($this->dir . '/sort.bf', $input);
        sort($input);

        $this->assertSame($input, $output);
    }

    public function testSort2(): void
    {
        $source   = '4,1,3,2!!>>,[>>,]<<[[-<+<]>[>[>>]<[.[-]<[[>>+<<-]<]>>]>]<<]';
        $output   = $this->bf->run($source);
        $expected = [1, 2, 3, 4];

        $this->assertSame($expected, $output);
    }

    protected function setUp(): void
    {
        $this->dir = realpath(__DIR__ . '/scripts');
        $this->bf  = new Brainfart(1000, true);
    }
}

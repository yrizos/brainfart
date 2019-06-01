<?php declare (strict_types = 1);

namespace Brainfart;

use Brainfart\Parser\Parser;
use Brainfart\VM\Output;
use Brainfart\VM\VM;

class Brainfart
{
    public const VERSION = '0.2.0';

    /**
     * @var bool
     */
    private $optimize = true;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var VM
     */
    private $vm;

    public function __construct(
        int $loopLimit = 100,
        bool $optimize = true
    ) {
        $this->vm     = new VM([], $loopLimit);
        $this->parser = new Parser();

        $this->setOptimize($optimize);
    }

    /**
     * @param string[]|string $input
     *
     * @return string[]|string
     */
    public function run(
        string $source,
        $input = '',
        int $fetchMode = Output::FETCH_ARRAY
    ) {
        $this->parser->loadSource($source);

        if ($this->parser->getFlag('string_output') === true) {
            $fetchMode = Output::FETCH_STRING;
        }

        $appLoop  = $this->parser->parse($this->optimize);
        $appInput = $this->parser->getInput();

        if (! empty($appInput)) {
            $input = $appInput;
        }

        $this->vm->init($input);

        $appLoop->execute($this->vm);

        return $this->vm->getOutput()->fetch($fetchMode);
    }

    public function setOptimize(bool $optimize = true): self
    {
        $this->optimize = ($optimize === true);

        return $this;
    }
}

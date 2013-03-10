<?php

namespace Brainfart;

use Brainfart\VM\Output;
use Brainfart\Parser\Parser;
use Brainfart\VM\VM;

class Brainfart
{

    private $optimize = true;

    /**
     * @var VM
     */
    private $vm;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Output
     */
    private $output;

    /**
     * @param int  $loopLimit
     * @param bool $optimize
     */
    public function __construct($loopLimit = 100, $optimize = true) {
        $this->vm     = new VM(array(), $loopLimit);
        $this->parser = new Parser();

        $this->setOptimize($optimize);
    }

    /**
     * @param bool $optimize
     *
     * @return Brainfart
     */
    public function setOptimize($optimize = true) {
        $this->optimize = ($optimize === true);

        return $this;
    }

    /**
     * @param string $source
     * @param string $input
     * @param int    $fetchMode
     *
     * @return array|string
     */
    public function run($source, $input = "", $fetchMode = Output::FETCH_ARRAY) {
        $this->parser->loadSource($source);
        if ($this->parser->getFlag("string_output") === true) $fetchMode = Output::FETCH_STRING;

        $appLoop  = $this->parser->parse($this->optimize);
        $appInput = $this->parser->getInput();
        if (!empty($appInput)) $input = $appInput;

        $this->vm->init($input);

        $appLoop->execute($this->vm);

        return $this->vm->getOutput()->fetch($fetchMode);
    }
}

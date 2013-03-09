<?php

namespace Brainfart\VM;

class VM
{

    /**
     * @var Input
     */
    private $input;

    /**
     * @var Output
     */
    private $output;

    /**
     * @var Memory
     */
    private $memory;

    /**
     * @var int
     */
    private $loopLimit = 0;

    /**
     * @param string|array $input
     */
    public function __construct($input = array(), $loopLimit) {
        $this->input     = new Input($input);
        $this->output    = new Output();
        $this->memory    = new Memory();
        $this->loopLimit = is_numeric($loopLimit) && $loopLimit > 0 ? (int) $loopLimit : 0;
    }

    /**
     * @return Input
     */
    public function getInput() { return $this->input; }

    /**
     * @return Output
     */
    public function getOutput() { return $this->output; }

    /**
     * @return Memory
     */
    public function getMemory() { return $this->memory; }

    /**
     * @return int
     */
    public function getLoopLimit() { return $this->loopLimit; }
}

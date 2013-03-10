<?php

namespace Brainfart\VM;

/** @noinspection PhpDocSignatureInspection */
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
    public function __construct($input = array(), $loopLimit = 0) {
        $this->init($input, $loopLimit);
    }

    /**
     * @return VM
     */
    public function init($input = array(), $loopLimit = 0) {
        $this->input  = new Input($input);
        $this->output = new Output();
        $this->memory = new Memory();

        $this->setLoopLimit($loopLimit);

        return $this;
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
     * @param int $loopLimit
     *
     * @return VM
     */
    public function setLoopLimit($loopLimit = 100) {
        $this->loopLimit = is_numeric($loopLimit) && $loopLimit > 0 ? (int) $loopLimit : 0;

        return $this;
    }

    /**
     * @return int
     */
    public function getLoopLimit() { return $this->loopLimit; }
}

<?php declare(strict_types=1);

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
     * @param scalar|scalar[] $input
     */
    public function __construct($input = [], int $loopLimit = 0)
    {
        $this->init($input, $loopLimit);
    }

    /**
     * @param scalar|scalar[] $input
     */
    public function init($input = [], int $loopLimit = 0): self
    {
        $this->input  = new Input($input);
        $this->output = new Output();
        $this->memory = new Memory();

        $this->setLoopLimit($loopLimit);

        return $this;
    }

    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

    /**
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }

    /**
     * @return Memory
     */
    public function getMemory(): Memory
    {
        return $this->memory;
    }

    /**
     * @return VM
     */
    public function setLoopLimit(int $loopLimit = 100): self
    {
        $this->loopLimit = is_numeric($loopLimit) && $loopLimit > 0 ? (int) $loopLimit : 0;

        return $this;
    }

    public function getLoopLimit(): int
    {
        return $this->loopLimit;
    }
}

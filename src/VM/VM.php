<?php declare(strict_types = 1);

namespace Brainfart\VM;

/** @noinspection PhpDocSignatureInspection */
class VM
{
    /**
     * @var Input
     */
    private $input;

    /**
     * @var int
     */
    private $loopLimit = 0;

    /**
     * @var Memory
     */
    private $memory;

    /**
     * @var Output
     */
    private $output;

    /**
     * @param scalar|scalar[] $input
     */
    public function __construct(
        $input = [],
        int $loopLimit = 0
    ) {
        $this->init($input, $loopLimit);
    }

    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

    public function getLoopLimit(): int
    {
        return $this->loopLimit;
    }

    /**
     * @return Memory
     */
    public function getMemory(): Memory
    {
        return $this->memory;
    }

    /**
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }

    /**
     * @param string|string[] $input
     */
    public function init(
        $input = [],
        int $loopLimit = 0
    ): self {
        $this->input  = new Input($input);
        $this->output = new Output();
        $this->memory = new Memory();

        $this->setLoopLimit($loopLimit);

        return $this;
    }

    /**
     * @return VM
     */
    public function setLoopLimit(int $loopLimit = 100): self
    {
        $this->loopLimit = $loopLimit > 0 ? $loopLimit : 0;

        return $this;
    }
}

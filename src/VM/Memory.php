<?php declare(strict_types=1);

namespace Brainfart\VM;

class Memory
{
    /**
     * @var int[]
     */
    private $memory = [];

    /**
     * @var int
     */
    private $pointer = 0;

    /**
     * @param int $value
     *
     * @return Memory
     */
    public function move(int $value): self
    {
        $this->pointer += is_numeric($value) ? (int) $value : 0;

        return $this;
    }

    /**
     * @return int
     */
    public function fetch(): int
    {
        return isset($this->memory[$this->pointer]) ? $this->memory[$this->pointer] : 0;
    }

    /**
     * @param int $value
     *
     * @return Memory
     */
    public function store(int $value): self
    {
        $this->memory[$this->pointer] = $this->fetch() + (is_numeric($value) ? (int) $value : 0);

        return $this;
    }
}

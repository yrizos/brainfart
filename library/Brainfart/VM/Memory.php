<?php

namespace Brainfart\VM;

class Memory
{

    private $memory = array();
    private $pointer = 0;

    /**
     * @param int $value
     *
     * @return Memory
     */
    public function move($value) {
        $this->pointer += is_numeric($value) ? (int) $value : 0;

        return $this;
    }

    /**
     * @return int
     */
    public function fetch() {
        return isset($this->memory[$this->pointer]) ? $this->memory[$this->pointer] : 0;
    }

    /**
     * @param int $value
     *
     * @return Memory
     */
    public function store($value) {
        $this->memory[$this->pointer] = $this->fetch() + (is_numeric($value) ? (int) $value : 0);

        return $this;
    }

}

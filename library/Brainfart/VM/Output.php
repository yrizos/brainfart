<?php

namespace Brainfart\VM;

class Output
{

    const FETCH_ARRAY  = 0;
    const FETCH_STRING = 1;

    private $output = array();

    /**
     * @param int $value
     *
     * @return Output
     */
    public function store($value) {
        $this->output[] = $value;

        return $this;
    }

    /**
     * @return array|string
     */
    public function fetch($fetchMode = self::FETCH_ARRAY) {
        return
            ($fetchMode === self::FETCH_STRING)
                ? implode("", array_map("chr", $this->output))
                : $this->output;
    }

}

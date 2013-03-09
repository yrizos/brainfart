<?php

namespace Brainfart\VM;

class Input
{
    private $input = array();

    /**
     * @param $input
     */
    public function __construct($input) {
        $this->store($input);
    }

    /**
     * @param string|array $input
     *
     * @return Input
     * @throws \InvalidArgumentException
     */
    public function store($input) {
        if(is_scalar($input)) $input = str_split(trim($input));
        if(!is_array($input)) throw new \InvalidArgumentException();

        foreach($input as $key => $value) $input[$key] = is_numeric($value) ? (int) $value : ord($value);

        $this->input = $input;

        return $this;
    }

    /**
     * @return int
     */
    public function fetch() {
        return
            !(empty($this->input))
                ? array_shift($this->input)
                : 0;
    }


}

<?php declare(strict_types=1);

namespace Brainfart\VM;

class Input
{
    /**
     * @var string[]
     */
    private $input = [];

    /**
     * @param scalar|scalar[] $input
     */
    public function __construct($input)
    {
        $this->store($input);
    }

    /**
     * @param scalar|scalar[] $input
     */
    public function store($input): self
    {
        if (is_scalar($input)) {
            $input = str_split(trim($input));
        }

        if (! is_array($input)) {
            throw new \InvalidArgumentException('Input is invalid.');
        }

        foreach ($input as $key => $value) {
            $input[$key] = is_numeric($value) ? (int) $value : ord($value);
        }

        $this->input = $input;

        return $this;
    }

    public function fetch(): int
    {
        return ! (empty($this->input)) ? array_shift($this->input) : 0;
    }
}

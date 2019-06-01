<?php declare(strict_types=1);

namespace Brainfart\VM;

/** @noinspection PhpDocSignatureInspection */
class Output
{
    public const FETCH_ARRAY  = 0;

    public const FETCH_STRING = 1;

    /**
     * @var string[]
     */
    private $output = [];

    /**
     * @param int $value
     *
     * @return Output
     */
    public function store(int $value): self
    {
        $this->output[] = $value;

        return $this;
    }

    /**
     * @return string[]|string
     */
    public function fetch(int $fetchMode = self::FETCH_ARRAY)
    {
        return $fetchMode === self::FETCH_STRING
        ? implode('', array_map('chr', $this->output))
        : $this->output;
    }
}

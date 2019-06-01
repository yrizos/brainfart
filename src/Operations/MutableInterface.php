<?php declare(strict_types=1);

namespace Brainfart\Operations;

interface MutableInterface
{
    /**
     * @param int $value
     */
    public function __construct(int $value);

    /**
     * @param int $value
     */
    public function setValue(int $value): void;

    public function getValue(): void;

    public function combine(self $operation): void;
}

<?php declare (strict_types = 1);

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
    public function setValue(int $value): self;

    public function getValue(): int;

    /**
     * @return bool|MutableTrait
     */
    public function combine(self $operation);
}

<?php declare(strict_types=1);

namespace Brainfart\Operations;

trait MutableTrait
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    public function setValue(int $value): self
    {
        $this->value = is_numeric($value) ? (int) $value : 0;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return bool|MutableTrait
     */
    public function combine(MutableInterface $operation)
    {
        $class = static::class;

        if ($operation instanceof $class) {
            $this->setValue($this->getValue() + $operation->getValue());

            return $this;
        }

        return false;
    }
}

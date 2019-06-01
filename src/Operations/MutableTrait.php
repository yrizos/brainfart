<?php declare(strict_types = 1);

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

    /**
     * @return bool|MutableInterface
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

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): MutableInterface
    {
        $this->value = is_numeric($value) ? (int) $value : 0;

        return $this;
    }
}

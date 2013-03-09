<?php

namespace Brainfart\Operations;

/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedClassInspection */
trait MutableTrait
{

    /**
     * @var int
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value) {
        $this->setValue($value);
    }

    /**
     * @param int $value
     *
     * @return OperationTrait
     */
    public function setValue($value) {
        $this->value = is_numeric($value) ? (int) $value : 0;

        return $this;
    }

    /**
     * @return int
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param MutableInterface $operation
     *
     * @return bool|MutableTrait
     */
    public function combine(MutableInterface $operation) {
        $class = get_class($this);
        if ($operation instanceof $class) {
            $this->setValue($this->getValue() + $operation->getValue());

            return $this;
        }

        return false;
    }
}

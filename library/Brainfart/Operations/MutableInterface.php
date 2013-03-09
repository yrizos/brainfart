<?php

namespace Brainfart\Operations;

interface MutableInterface
{

    public function __construct($value);

    public function setValue($value);

    public function getValue();

    public function combine(MutableInterface $operation);
}

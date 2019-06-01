<?php declare(strict_types = 1);

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class ChangeOperation implements OperationInterface, MutableInterface
{
    use MutableTrait;

    public function execute(VM $vm): void
    {
        $vm->getMemory()->store($this->getValue());
    }
}

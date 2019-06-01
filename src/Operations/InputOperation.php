<?php declare(strict_types=1);

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class InputOperation implements OperationInterface
{
    public function execute(VM $vm): void
    {
        $vm->getMemory()->store($vm->getInput()->fetch());
    }
}

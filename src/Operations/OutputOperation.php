<?php declare(strict_types=1);

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class OutputOperation implements OperationInterface
{
    public function execute(VM $vm): void
    {
        $vm->getOutput()->store($vm->getMemory()->fetch());
    }
}

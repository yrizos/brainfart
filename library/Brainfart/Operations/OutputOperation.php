<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class OutputOperation implements OperationInterface
{

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        $vm->getOutput()->store($vm->getMemory()->fetch());
    }

}

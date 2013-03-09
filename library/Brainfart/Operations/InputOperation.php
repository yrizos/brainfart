<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class InputOperation implements OperationInterface
{

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        $vm->getMemory()->store($vm->getInput()->fetch());
    }

}

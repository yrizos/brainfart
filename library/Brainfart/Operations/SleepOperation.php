<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class SleepOperation implements OperationInterface
{

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        sleep($vm->getMemory()->fetch());
    }

}

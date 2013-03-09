<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class ChangeOperation implements OperationInterface, MutableInterface
{

    use MutableTrait;

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        $vm->getMemory()->store($this->getValue());
    }

}

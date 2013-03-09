<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class MoveOperation implements OperationInterface, MutableInterface
{

    use MutableTrait;

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        $vm->getMemory()->move($this->getValue());
    }

}

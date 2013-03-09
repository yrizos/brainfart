<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

interface OperationInterface
{

    public function execute(VM $vm);

}

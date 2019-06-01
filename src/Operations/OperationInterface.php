<?php declare(strict_types=1);

namespace Brainfart\Operations;

use Brainfart\VM\VM;

interface OperationInterface
{
    public function execute(VM $vm): void;
}

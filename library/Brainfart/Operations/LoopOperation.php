<?php

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class LoopOperation implements OperationInterface
{

    private $master = false;
    private $operations = array();

    /**
     * @param array $operations
     * @param bool  $master
     */
    public function __construct(array $operations, $master = false) {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->setOperations($operations)->setMaster($master);
    }

    /**
     * @param array $operations
     *
     * @return InputOperation
     */
    public function setOperations(array $operations) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * @return array
     */
    public function getOperations() {
        return $this->operations;
    }

    /**
     * @param $master
     *
     * @return InputOperation
     */
    public function setMaster($master) {
        $this->master = ($master === true);

        return $this;
    }

    /**
     * @return bool
     */
    public function getMaster() {
        return $this->master;
    }

    /**
     * @param \Brainfart\VM\VM $vm
     */
    public function execute(VM $vm) {
        $operations = $this->getOperations();
        $limit      = $vm->getLoopLimit();

        $i = 0;
        while (
            $this->getMaster() // master loop is the whole app, runs regardless of memory value
            || ($vm->getMemory()->fetch() != 0)
        ) {
            foreach ($operations as $operation) /** @noinspection PhpUndefinedMethodInspection */
                $operation->execute($vm);

            if ($this->getMaster()) break;

            $i++;
            if ($limit > 0 && $limit < $i) throw new \RuntimeException("Limit of {$limit} operations per loop reached.");
        }
    }

}

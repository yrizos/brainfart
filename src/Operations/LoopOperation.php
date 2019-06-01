<?php declare(strict_types=1);

namespace Brainfart\Operations;

use Brainfart\VM\VM;

class LoopOperation implements OperationInterface
{
    /**
     * @var bool
     */
    private $master = false;

    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * @param OperationInterface[] $operations
     * @param bool  $master
     */
    public function __construct(array $operations, bool $master = false)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->setOperations($operations)->setMaster($master);
    }

    /**
     * @param OperationInterface[] $operations
     */
    public function setOperations(array $operations): self
    {
        $this->operations = $operations;

        return $this;
    }

    /**
     * @return OperationInterface[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    public function setMaster(bool $master): self
    {
        $this->master = ($master === true);

        return $this;
    }

    public function getMaster(): bool
    {
        return $this->master;
    }

    public function execute(VM $vm): void
    {
        $operations = $this->getOperations();
        $limit      = $vm->getLoopLimit();

        $i = 0;

        while ($this->getMaster() // master loop is the whole app, runs regardless of memory value
             || ($vm->getMemory()->fetch() !== 0)
        ) {
            foreach ($operations as $operation) {
                $operation->execute($vm);
            }

            if ($this->getMaster()) {
                break;
            }

            $i++;

            if ($limit > 0 && $limit < $i) {
                throw new \RuntimeException("Limit of {$limit} operations per loop reached.");
            }
        }
    }
}

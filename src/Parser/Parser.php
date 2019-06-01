<?php declare(strict_types = 1);

namespace Brainfart\Parser;

use Brainfart\Operations\ChangeOperation;
use Brainfart\Operations\InputOperation;
use Brainfart\Operations\LoopOperation;
use Brainfart\Operations\MoveOperation;
use Brainfart\Operations\MutableInterface;
use Brainfart\Operations\OperationInterface;
use Brainfart\Operations\OutputOperation;
use Brainfart\Operations\SleepOperation;

class Parser extends Loader
{
    /**
     * @var LoopOperation
     */
    private $operations;

    public function getOperations(): \Brainfart\Operations\LoopOperation
    {
        return $this->operations;
    }

    public function parse(bool $optimize = true): \Brainfart\Operations\LoopOperation
    {
        if ($this->getFlag('no_optimization') === true) {
            $optimize = false;
        }

        $operations = $this->tokenize($this->getSource(), $optimize);

        return $this->operations = new LoopOperation($operations, true);
    }

    private function findLoopEnd(string $source): int
    {
        $posCloseBracket = strpos($source, ']');
        $posOpenBracket  = strpos($source, '[');

        if ($posOpenBracket === false || $posCloseBracket < $posOpenBracket) {
            return $posCloseBracket;
        }

        $source[$posOpenBracket] = $source[$posCloseBracket] = '_';

        return $this->findLoopEnd($source);
    }

    private function getOperation(string $token): ?OperationInterface
    {
        $operation = null;

        switch ($token) {
            case '>':
                $operation = new MoveOperation(1);
                break;
            case '<':
                $operation = new MoveOperation(-1);
                break;
            case '+':
                $operation = new ChangeOperation(1);
                break;
            case '-':
                $operation = new ChangeOperation(-1);
                break;
            case '.':
                $operation = new OutputOperation();
                break;
            case ',':
                $operation = new InputOperation();
                break;
            case '~':
                $operation = new SleepOperation();
        }

        return $operation;
    }

    /**
     * @return OperationInterface[]
     */
    private function tokenize(
        string $source,
        bool $optimize
    ): array {
        $result   = [];
        $optimize = $optimize === true;
        $length   = strlen($source);

        for ($i = 0; $i < $length; $i++) {
            $token = $source[$i] ?? false;

            if (! $token) {
                break;
            }

            if ($token === '[') {
                $loopEnd = $this->findLoopEnd(substr($source, $i + 1));

                if (! $loopEnd) {
                    throw new \LogicException('Neverending loop.');
                }

                $loopSource = substr($source, $i + 1, $loopEnd);
                $loopTokens = $this->tokenize($loopSource, $optimize);
                $operation  = new LoopOperation($loopTokens);

                $i += $loopEnd + 1;
            } else {
                $operation = $this->getOperation($token);

                if (! $operation) {
                    continue;
                }

                if ($optimize && ($operation instanceof MutableInterface)) {
                    $index    = count($result) - 1;
                    $previous = $result[$index] ?? false;
                    $combined = $previous instanceof MutableInterface ? $previous->combine($operation) : false;

                    if ($combined) {
                        $result[$index] = $combined;
                        continue;
                    }
                }
            }

            $result[] = $operation;
        }

        return $result;
    }
}

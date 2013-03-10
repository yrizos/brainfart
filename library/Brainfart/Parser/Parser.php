<?php

namespace Brainfart\Parser;

use Brainfart\Operations\LoopOperation;
use Brainfart\Operations\SleepOperation;
use Brainfart\Operations\ChangeOperation;
use Brainfart\Operations\MoveOperation;
use Brainfart\Operations\InputOperation;
use Brainfart\Operations\OutputOperation;
use Brainfart\Operations\MutableInterface;

class Parser extends Loader
{

    /**
     * @var LoopOperation
     */
    private $operations;

    /**
     * @param bool $optimize
     *
     * @return \Brainfart\Operations\LoopOperation
     */
    public function parse($optimize = true) {
        if ($this->getFlag("no_optimization") === true) $optimize = false;

        $operations = $this->tokenize($this->getSource(), $optimize);

        return $this->operations = new LoopOperation($operations, true);
    }

    /**
     * @return \Brainfart\Operations\LoopOperation
     */
    public function getOperations() {
        return $this->operations;
    }

    /**
     * @param string $source
     * @param bool   $optimize
     *
     * @return array
     * @throws \LogicException
     */
    private function tokenize($source, $optimize) {
        $result   = array();
        $optimize = $optimize === true;
        $length   = strlen($source);

        for ($i = 0; $i < $length; $i++) {
            $token = isset($source[$i]) ? $source[$i] : false;
            if (!$token) break;

            if ($token == "[") {
                $loopEnd = $this->findLoopEnd(substr($source, $i + 1));
                if (!$loopEnd) throw new \LogicException("Neverending loop.");

                $loopSource = substr($source, $i + 1, $loopEnd);
                $loopTokens = $this->tokenize($loopSource, $optimize);
                $operation  = new LoopOperation($loopTokens);

                $i += $loopEnd + 1;
            } else {
                $operation = $this->getOperation($token);
                if (!$operation) continue;

                if ($optimize && ($operation instanceof MutableInterface)) {
                    $index    = count($result) - 1;
                    $previous = isset($result[$index]) ? $result[$index] : false;
                    $combined = ($previous instanceof MutableInterface) ? $previous->combine($operation) : false;

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

    /**
     * @param $source
     *
     * @return int
     */
    private function findLoopEnd($source) {
        $posCloseBracket = strpos($source, "]");
        $posOpenBracket  = strpos($source, "[");

        if ($posOpenBracket === false || $posCloseBracket < $posOpenBracket) return $posCloseBracket;
        $source[$posOpenBracket] = $source[$posCloseBracket] = "_";

        return $this->findLoopEnd($source);
    }

    /**
     * @param $token
     *
     * @return bool|\Brainfart\Operations\ChangeOperation|\Brainfart\Operations\MoveOperation|InputOperation|OutputOperation
     */
    private function getOperation($token) {
        $operation = false;
        switch ($token) {
            case ">":
                $operation = new MoveOperation(1);
                break;
            case "<":
                $operation = new MoveOperation(-1);
                break;
            case "+":
                $operation = new ChangeOperation(1);
                break;
            case "-":
                $operation = new ChangeOperation(-1);
                break;
            case ".":
                $operation = new OutputOperation();
                break;
            case ",":
                $operation = new InputOperation();
                break;
            case "~":
                $operation = new SleepOperation();
        }

        return $operation;
    }

}

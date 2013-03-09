<?php

namespace Brainfart;

use Brainfart\VM\Output;
use Brainfart\Parser\Parser;
use Brainfart\VM\VM;

class Brainfart
{

    public static function run($source, $input = "", $fetchMode = Output::FETCH_ARRAY) {
        $parser = new Parser($source);
        $app    = $parser->parse(true);
        $vm     = new VM($input);

        $app->execute($vm);

        return $vm->getOutput()->fetch($fetchMode);
    }

}

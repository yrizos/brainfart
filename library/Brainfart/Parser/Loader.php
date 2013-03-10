<?php

namespace Brainfart\Parser;

class Loader
{

    /**
     * @var string
     */
    private $source = "";

    /**
     * @param null|string $source
     */
    public function __construct($source = null) {
        if (!is_null($source)) $this->loadSource($source);
    }

    /**
     * @param string|file $source
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function loadSource($source) {
        if (is_file($source)) $source = @ file_get_contents($source);
        if (!is_string($source)) throw new \InvalidArgumentException();

        $source = $this->prepare($source);
        $source = $this->skintoad($source);
        $source = $this->cleanup($source);

        return $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return string mixed
     */
    private function prepare($source) {
        return preg_replace('/\s+/', "", strtolower($source));
    }

    /**
     * @param $source
     *
     * @return mixed
     */
    private function skintoad($source) {
        if (!preg_match_all('/:(.*?);/', $source, $matches)) return $source;

        foreach ($matches[0] as $match) {
            $source = str_replace($match, "", $source);
            $match  = trim($match, ":;");
            if (preg_match('/^[a-zA-Z0-9_]*/', $match, $identifier)) {
                $identifier = $identifier[0];
                $sequence   = str_replace($identifier, "", $match);
                $source     = str_replace($identifier, $sequence, $source);
            }
        }

        return $source;
    }

    /**
     * @param $source
     *
     * @return string
     */
    private function cleanup($source) {
        return preg_replace('/[^<|>|\-|\+|\.|\,|\]|\[]/', "", $source);
    }

}

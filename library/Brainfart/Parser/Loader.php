<?php

namespace Brainfart\Parser;

class Loader
{

    /**
     * @var array
     */
    private $input;

    /**
     * @var string
     */
    private $source = "";

    /**
     * @var bool
     */
    private $optimize;

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
     * @return array
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * @return bool
     */
    public function getOptimize() {
        return $this->optimize;
    }

    /**
     * @param string $input
     *
     * @return Loader
     * @throws \InvalidArgumentException
     */
    public function setInput($input) {
        if (!is_scalar($input)) throw new \InvalidArgumentException();

        $input = (string) $input;
        $input = trim($input, ", ");
        $input = explode(",", $input);
        $input = array_map("trim", $input);

        $this->input = $input;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return string mixed
     */
    private function prepare($source) {
        if (strpos($source, "@@") !== false) {
            $this->optimize = false;
            $source         = str_replace("@@", "", $source);
        }

        $pos = strpos($source, "!!");
        if ($pos !== false) {
            $input  = substr($source, 0, $pos);
            $source = substr($source, $pos + 2);

            $this->setInput($input);
        }

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

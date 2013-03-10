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
     * @var array
     */
    private $flags = array();

    /**
     * @param null|string $source
     */
    public function __construct($source = null) {
        if (!is_null($source)) $this->loadSource($source);

        $this->setFlag("no_optimization", false)->setFlag("string_output", false);
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
     * @return null|bool
     */
    public function getFlag($flag = null) {
        if (is_null($flag) || !is_scalar($flag)) return $this->flags;

        $flag = strtolower(trim($flag));

        return
            isset($this->flags[$flag])
                ? $this->flags[$flag]
                : null;
    }

    /**
     * @param string    $flag
     * @param bool|null $value
     *
     * @return Loader
     */
    protected function setFlag($flag, $value = null) {
        $flag = (!is_scalar($flag)) ? "unknown" : strtolower(trim($flag));
        if (!is_null($value)) $value = ($value === true);

        $this->flags[$flag] = $value;

        return $this;
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
        $flags = array("@@" => "no_optimization", "$$" => "string_output");

        foreach ($flags as $operator => $flag) {
            if (strpos($source, $operator) !== false) {
                $this->setFlag($flag, true);
                $source = str_replace($operator, "", $source);
            }
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
        return preg_replace('/[^<|>|\-|\+|\.|\~|\,|\]|\[]/', "", $source);
    }

}

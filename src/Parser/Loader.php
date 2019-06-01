<?php declare(strict_types=1);

namespace Brainfart\Parser;

class Loader
{
    /**
     * @var string[]
     */
    private $input;

    /**
     * @var string
     */
    private $source = '';

    /**
     * @var mixed[]
     */
    private $flags = [];

    public function __construct(?string $source = null)
    {
        if ($source !== null) {
            $this->loadSource($source);
        }

        $this->setFlag('no_optimization', false)->setFlag('string_output', false);
    }

    public function loadSource(string $source): string
    {
        if (is_file($source)) {
            $source = @file_get_contents($source);
        }

        if (! is_string($source)) {
            throw new \InvalidArgumentException($source . ' is invalid.');
        }

        $source = $this->prepare($source);
        $source = $this->skintoad($source);
        $source = $this->cleanup($source);

        return $this->source = $source;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string[]
     */
    public function getInput(): array
    {
        return $this->input;
    }

    /**
     * @param string|null $flag
     */
    public function getFlag(?string $flag = null): ?bool
    {
        if ($flag === null || ! is_scalar($flag)) {
            return $this->flags;
        }

        $flag = strtolower(trim($flag));

        return isset($this->flags[$flag])
        ? $this->flags[$flag]
        : null;
    }

    public function setInput(string $input): self
    {
        $input = trim($input, ', ');
        $input = explode(',', $input);
        $input = array_map('trim', $input);

        $this->input = $input;

        return $this;
    }

    protected function setFlag(string $flag, ?bool $value = null): self
    {
        $flag = ! is_scalar($flag) ? 'unknown' : strtolower(trim($flag));

        if ($value !== null) {
            $value = ($value === true);
        }

        $this->flags[$flag] = $value;

        return $this;
    }

    private function prepare(string $source): string
    {
        $flags = ['@@' => 'no_optimization', '$$' => 'string_output'];

        foreach ($flags as $operator => $flag) {
            if (strpos($source, $operator) !== false) {
                $this->setFlag($flag, true);
                $source = str_replace($operator, '', $source);
            }
        }

        $pos = strpos($source, '!!');

        if ($pos !== false) {
            $input  = substr($source, 0, $pos);
            $source = substr($source, $pos + 2);

            $this->setInput($input);
        }

        return preg_replace('/\s+/', '', strtolower($source));
    }

    private function skintoad(string $source): string
    {
        if (! preg_match_all('/:(.*?);/', $source, $matches)) {
            return $source;
        }

        foreach ($matches[0] as $match) {
            $source = str_replace($match, '', $source);
            $match  = trim($match, ':;');

            if (preg_match('/^[a-zA-Z0-9_]*/', $match, $identifier)) {
                $identifier = $identifier[0];
                $sequence   = str_replace($identifier, '', $match);
                $source     = str_replace($identifier, $sequence, $source);
            }
        }

        return $source;
    }

    private function cleanup(string $source): string
    {
        return preg_replace('/[^<|>|\-|\+|\.|\~|\,|\]|\[]/', '', $source);
    }
}

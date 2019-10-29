<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Messaging\Command\Command\Command;

class TranslateCurrency extends Command
{
    /** @var string */
    private $code;

    /** @var string[] */
    private $names;

    /**
     * @param string   $code
     * @param string[] $names
     */
    public function __construct(string $code, array $names = [])
    {
        $this->code = $code;
        $this->names = $names;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}

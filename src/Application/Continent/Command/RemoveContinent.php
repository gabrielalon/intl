<?php

namespace N3ttech\Intl\Application\Continent\Command;

use N3ttech\Messaging\Command\Command\Command;

class RemoveContinent extends Command
{
    /** @var string */
    private $code;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}

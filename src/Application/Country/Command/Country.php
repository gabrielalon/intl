<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Messaging\Command\Command\Command;

abstract class Country extends Command
{
    /** @var string */
    private $code;

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    protected function setCode(string $code): void
    {
        $this->code = $code;
    }
}

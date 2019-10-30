<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Messaging\Command\Command\Command;

class CreateLanguage extends Command
{
    /** @var string */
    private $code;

    /** @var string[] */
    private $names;

    /**
     * @param string $code
     * @param array  $names
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

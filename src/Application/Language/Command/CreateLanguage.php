<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Messaging\Command\Command\Command;

class CreateLanguage extends Command
{
    /** @var string */
    private $locale;

    /** @var string[] */
    private $names;

    /**
     * @param string $locale
     * @param array  $names
     */
    public function __construct(string $locale, array $names = [])
    {
        $this->locale = $locale;
        $this->names = $names;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}

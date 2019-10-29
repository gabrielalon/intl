<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Messaging\Command\Command\Command;

class RemoveLanguage extends Command
{
    /** @var string */
    private $locale;

    /**
     * @param string $locale
     */
    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }
}

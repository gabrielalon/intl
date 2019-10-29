<?php

namespace N3ttech\Intl\Application\Language\Query\V1;

use N3ttech\Intl\Application\Language\Query\ReadModel;
use N3ttech\Messaging\Query\Query\Query;

class FindOneByLocale extends Query
{
    /** @var string */
    private $locale;

    /** @var ReadModel\Language */
    private $language;

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

    /**
     * @return ReadModel\Language
     */
    public function getLanguage(): ReadModel\Language
    {
        return $this->language;
    }

    /**
     * @param ReadModel\Language $language
     */
    public function setLanguage(ReadModel\Language $language): void
    {
        $this->language = $language;
    }
}

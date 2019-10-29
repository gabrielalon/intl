<?php

namespace N3ttech\Intl\Infrastructure\Query\Language;

use N3ttech\Intl\Application\Language\Query;

class InMemoryLanguageQuery implements Query\V1\LanguageQuery
{
    /** @var Query\ReadModel\LanguageCollection */
    private $entities;

    /**
     * @param Query\ReadModel\LanguageCollection $entities
     */
    public function __construct(Query\ReadModel\LanguageCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByLocale $query
     */
    public function findOneByLocale(Query\V1\FindOneByLocale $query): void
    {
        $this->checkExistence($query->getLocale());

        $query->setLanguage($this->entities->get($query->getLocale()));
    }

    /**
     * @param string $locale
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $locale): void
    {
        if (false === $this->entities->has($locale)) {
            throw new \RuntimeException(\sprintf(
                'Language does not exists on given locale: %s',
                $locale
            ));
        }
    }
}

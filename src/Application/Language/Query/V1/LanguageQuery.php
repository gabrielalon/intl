<?php

namespace N3ttech\Intl\Application\Language\Query\V1;

interface LanguageQuery
{
    /**
     * @param FindOneByLocale $query
     */
    public function findOneByLocale(FindOneByLocale $query): void;
}

<?php

namespace N3ttech\Intl\Application\Currency\Query\V1;

interface CurrencyQuery
{
    /**
     * @param FindOneByCode $query
     */
    public function findOneByCode(FindOneByCode $query): void;
}

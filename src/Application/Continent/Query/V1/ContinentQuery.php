<?php

namespace N3ttech\Intl\Application\Continent\Query\V1;

interface ContinentQuery
{
    /**
     * @param FindOneByCode $query
     */
    public function findOneByCode(FindOneByCode $query): void;
}

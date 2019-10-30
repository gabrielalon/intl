<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

interface CountryQuery
{
    /**
     * @param FindOneByCode $query
     */
    public function findOneByCode(FindOneByCode $query): void;

    /**
     * @param FindAllActive $query
     */
    public function findAllActive(FindAllActive $query): void;
}

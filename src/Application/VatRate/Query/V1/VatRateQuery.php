<?php

namespace N3ttech\Intl\Application\VatRate\Query\V1;

interface VatRateQuery
{
    /**
     * @param FindOneByIdentity $query
     */
    public function findOneByIdentity(FindOneByIdentity $query): void;
}

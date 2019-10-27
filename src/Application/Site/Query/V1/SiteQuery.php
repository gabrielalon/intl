<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

interface SiteQuery
{
    /**
     * @param FindOneByIdentity $query
     */
    public function findOneByIdentity(FindOneByIdentity $query): void;

    /**
     * @param FindOneByHost $query
     */
    public function findOneByHost(FindOneByHost $query): void;
}

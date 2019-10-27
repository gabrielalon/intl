<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class SiteQueryHandler implements QueryHandler
{
    /** @var SiteQuery */
    protected $ask;

    /**
     * @param SiteQuery $ask
     */
    public function __construct(SiteQuery $ask)
    {
        $this->ask = $ask;
    }
}

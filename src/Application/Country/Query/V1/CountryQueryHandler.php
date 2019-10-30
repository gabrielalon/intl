<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class CountryQueryHandler implements QueryHandler
{
    /** @var CountryQuery */
    protected $ask;

    /**
     * @param CountryQuery $ask
     */
    public function __construct(CountryQuery $ask)
    {
        $this->ask = $ask;
    }
}

<?php

namespace N3ttech\Intl\Application\Currency\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class CurrencyQueryHandler implements QueryHandler
{
    /** @var CurrencyQuery */
    protected $ask;

    /**
     * @param CurrencyQuery $ask
     */
    public function __construct(CurrencyQuery $ask)
    {
        $this->ask = $ask;
    }
}

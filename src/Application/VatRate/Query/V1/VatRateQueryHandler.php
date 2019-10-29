<?php

namespace N3ttech\Intl\Application\VatRate\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class VatRateQueryHandler implements QueryHandler
{
    /** @var VatRateQuery */
    protected $ask;

    /**
     * @param VatRateQuery $ask
     */
    public function __construct(VatRateQuery $ask)
    {
        $this->ask = $ask;
    }
}

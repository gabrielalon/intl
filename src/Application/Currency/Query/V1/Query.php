<?php

namespace N3ttech\Intl\Application\Currency\Query\V1;

use N3ttech\Intl\Application\Currency\Query\ReadModel\Currency;

abstract class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var Currency */
    private $currency;

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }
}

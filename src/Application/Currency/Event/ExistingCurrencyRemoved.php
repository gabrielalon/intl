<?php

namespace N3ttech\Intl\Application\Currency\Event;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingCurrencyRemoved extends CurrencyEvent
{
    /**
     * @param Currency $currency
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $currency): void
    {
        $currency->setCode($this->currencyCode());
    }
}

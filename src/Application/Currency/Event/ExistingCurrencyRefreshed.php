<?php

namespace N3ttech\Intl\Application\Currency\Event;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCurrencyRefreshed extends CurrencyEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Number\Decimal
     */
    public function currencyRate(): VO\Number\Decimal
    {
        return VO\Number\Decimal::fromFloat((float) ($this->payload['rate'] ?? 0.0));
    }

    /**
     * @param Currency $currency
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $currency): void
    {
        $currency->setCode($this->currencyCode());
        $currency->setRate($this->currencyRate());
    }
}

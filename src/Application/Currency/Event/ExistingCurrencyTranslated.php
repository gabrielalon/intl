<?php

namespace N3ttech\Intl\Application\Currency\Event;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCurrencyTranslated extends CurrencyEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Locales
     */
    public function currencyNames(): VO\Intl\Language\Locales
    {
        return VO\Intl\Language\Locales::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @param Currency $currency
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $currency): void
    {
        $currency->setCode($this->currencyCode());
        $currency->setNames($this->currencyNames());
    }
}

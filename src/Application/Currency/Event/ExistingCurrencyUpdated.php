<?php

namespace N3ttech\Intl\Application\Currency\Event;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCurrencyUpdated extends CurrencyEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function currencySymbol(): VO\Char\Text
    {
        return VO\Char\Text::fromString($this->payload['symbol'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function currencyPriceFormat(): VO\Char\Text
    {
        return VO\Char\Text::fromString($this->payload['price_format'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function currencyPriceDecimalSeparator(): VO\Char\Text
    {
        return VO\Char\Text::fromString($this->payload['price_decimal_separator'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function currencyPriceThousandSeparator(): VO\Char\Text
    {
        return VO\Char\Text::fromString($this->payload['price_thousand_separator'] ?? '');
    }

    /**
     * @param Currency $currency
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $currency): void
    {
        $currency->setCode($this->currencyCode());
        $currency->setSymbol($this->currencySymbol());
        $currency->setPriceFormat($this->currencyPriceFormat());
        $currency->setPriceDecimalSeparator($this->currencyPriceDecimalSeparator());
        $currency->setPriceThousandSeparator($this->currencyPriceThousandSeparator());
    }
}

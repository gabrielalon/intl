<?php

namespace N3ttech\Intl\Domain\Model\Currency;

use N3ttech\Intl\Application\Currency\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Currency extends AggregateRoot
{
    /** @var VO\Char\Text */
    private $symbol;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /** @var VO\Number\Decimal */
    private $rate;

    /** @var VO\Char\Text */
    private $priceFormat;

    /**
     * @param VO\Intl\Currency\Code $code
     *
     * @return Currency
     */
    public function setCode(VO\Intl\Currency\Code $code): Currency
    {
        $this->setAggregateId($code);

        return $this;
    }

    /**
     * @param VO\Char\Text $symbol
     *
     * @return Currency
     */
    public function setSymbol(VO\Char\Text $symbol): Currency
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Locales $names
     *
     * @return Currency
     */
    public function setNames(VO\Intl\Language\Locales $names): Currency
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Number\Decimal $rate
     *
     * @return Currency
     */
    public function setRate(VO\Number\Decimal $rate): Currency
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @param VO\Char\Text $priceFormat
     *
     * @return Currency
     */
    public function setPriceFormat(VO\Char\Text $priceFormat): Currency
    {
        $this->priceFormat = $priceFormat;

        return $this;
    }

    /**
     * @param VO\Intl\Currency\Code $code
     * @param VO\Char\Text          $symbol
     * @param VO\Char\Text          $priceFormat
     *
     * @return Currency
     */
    public static function createNewCurrency(
        VO\Intl\Currency\Code $code,
        VO\Char\Text $symbol,
        VO\Char\Text $priceFormat
    ): Currency {
        $site = new Currency();

        $site->recordThat(Event\NewCurrencyCreated::occur($code->toString(), [
            'symbol' => $symbol->toString(),
            'price_format' => $priceFormat->toString(),
        ]));

        return $site;
    }

    /**
     * @param VO\Char\Text $symbol
     * @param VO\Char\Text $priceFormat
     */
    public function update(VO\Char\Text $symbol, VO\Char\Text $priceFormat): void
    {
        $this->recordThat(Event\ExistingCurrencyUpdated::occur($this->aggregateId(), [
            'symbol' => $symbol->toString(),
            'price_format' => $priceFormat->toString(),
        ]));
    }

    /**
     * @param VO\Intl\Language\Locales $names
     */
    public function translate(VO\Intl\Language\Locales $names): void
    {
        $this->recordThat(Event\ExistingCurrencyTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    /**
     * @param VO\Number\Decimal $rate
     */
    public function refresh(VO\Number\Decimal $rate): void
    {
        $this->recordThat(Event\ExistingCurrencyRefreshed::occur($this->aggregateId(), [
            'rate' => $rate->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingCurrencyRemoved::occur($this->aggregateId()));
    }
}

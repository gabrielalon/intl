<?php

namespace N3ttech\Intl\Application\Currency\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Currency implements Viewable
{
    /** @var VO\Intl\Currency\Code */
    private $code;

    /** @var VO\Char\Text */
    private $symbol;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /** @var VO\Number\Decimal */
    private $rate;

    /** @var VO\Char\Text */
    private $priceFormat;

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Currency
     */
    public static function fromCode(string $code): Currency
    {
        $currency = new static();

        return $currency->setCode(VO\Intl\Currency\Code::fromCode($code));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->code->toString();
    }

    /**
     * @return VO\Intl\Currency\Code
     */
    public function getCode(): VO\Intl\Currency\Code
    {
        return $this->code;
    }

    /**
     * @param VO\Intl\Currency\Code $code
     *
     * @return Currency
     */
    public function setCode(VO\Intl\Currency\Code $code): Currency
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function symbol(): string
    {
        return $this->symbol->toString();
    }

    /**
     * @return VO\Char\Text
     */
    public function getSymbol(): VO\Char\Text
    {
        return $this->symbol;
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
     * @return float
     */
    public function rate(): float
    {
        return $this->rate->raw();
    }

    /**
     * @return VO\Number\Decimal
     */
    public function getRate(): VO\Number\Decimal
    {
        return $this->rate;
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
     * @return array
     */
    public function names(): array
    {
        return $this->names->raw();
    }

    /**
     * @return VO\Intl\Language\Locales
     */
    public function getNames(): VO\Intl\Language\Locales
    {
        return $this->names;
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
     * @param string $locale
     * @param string $name
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Currency
     */
    public function addName(string $locale, string $name): Currency
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }

    /**
     * @return string
     */
    public function priceFormat(): string
    {
        return $this->priceFormat->toString();
    }

    /**
     * @return VO\Char\Text
     */
    public function getPriceFormat(): VO\Char\Text
    {
        return $this->priceFormat;
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
}

<?php

namespace N3ttech\Intl\Application\Country\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Country implements Viewable
{
    /** @var VO\Intl\Country\Code */
    private $code;

    /** @var VO\Intl\Continent\Code */
    private $continent;

    /** @var VO\Intl\Currency\Codes */
    private $currencies;

    /** @var VO\Intl\Language\Codes */
    private $languages;

    /** @var VO\Intl\Country\Regions */
    private $regions;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /** @var VO\Char\Text */
    private $dateFormat;

    /** @var VO\Char\Text */
    private $timeFormat;

    /** @var VO\Option\Check */
    private $active;

    /** @var VO\Identity\Uuid */
    private $vatRate;

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Country
     */
    public static function fromCode(string $code): Country
    {
        $country = new static();

        return $country->setCode(VO\Intl\Country\Code::fromCode($code));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->code->toString();
    }

    /**
     * @return VO\Intl\Country\Code
     */
    public function getCode(): VO\Intl\Country\Code
    {
        return $this->code;
    }

    /**
     * @param VO\Intl\Country\Code $code
     *
     * @return Country
     */
    public function setCode(VO\Intl\Country\Code $code): Country
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function continent(): string
    {
        return $this->continent->toString();
    }

    /**
     * @return VO\Intl\Continent\Code
     */
    public function getContinent(): VO\Intl\Continent\Code
    {
        return $this->continent;
    }

    /**
     * @param VO\Intl\Continent\Code $continent
     *
     * @return Country
     */
    public function setContinent(VO\Intl\Continent\Code $continent): Country
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * @return string[]
     */
    public function currencies(): array
    {
        return $this->currencies->raw();
    }

    /**
     * @return VO\Intl\Currency\Codes
     */
    public function getCurrencies(): VO\Intl\Currency\Codes
    {
        return $this->currencies;
    }

    /**
     * @param VO\Intl\Currency\Codes $currencies
     *
     * @return Country
     */
    public function setCurrencies(VO\Intl\Currency\Codes $currencies): Country
    {
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * @return string[]
     */
    public function languages(): array
    {
        return $this->languages->raw();
    }

    /**
     * @return VO\Intl\Language\Codes
     */
    public function getLanguages(): VO\Intl\Language\Codes
    {
        return $this->languages;
    }

    /**
     * @param VO\Intl\Language\Codes $languages
     *
     * @return Country
     */
    public function setLanguages(VO\Intl\Language\Codes $languages): Country
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * @return string[][]
     */
    public function regions(): array
    {
        return $this->regions->raw();
    }

    /**
     * @return VO\Intl\Country\Regions
     */
    public function getRegions(): VO\Intl\Country\Regions
    {
        return $this->regions;
    }

    /**
     * @param VO\Intl\Country\Regions $regions
     *
     * @return Country
     */
    public function setRegions(VO\Intl\Country\Regions $regions): Country
    {
        $this->regions = $regions;

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
     * @return Country
     */
    public function setNames(VO\Intl\Language\Locales $names): Country
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
     * @return Country
     */
    public function addName(string $locale, string $name): Country
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }

    /**
     * @return string
     */
    public function dateFormat(): string
    {
        return $this->dateFormat->toString();
    }

    /**
     * @return VO\Char\Text
     */
    public function getDateFormat(): VO\Char\Text
    {
        return $this->dateFormat;
    }

    /**
     * @param VO\Char\Text $dateFormat
     *
     * @return Country
     */
    public function setDateFormat(VO\Char\Text $dateFormat): Country
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function timeFormat(): string
    {
        return $this->timeFormat->toString();
    }

    /**
     * @return VO\Char\Text
     */
    public function getTimeFormat(): VO\Char\Text
    {
        return $this->timeFormat;
    }

    /**
     * @param VO\Char\Text $timeFormat
     *
     * @return Country
     */
    public function setTimeFormat(VO\Char\Text $timeFormat): Country
    {
        $this->timeFormat = $timeFormat;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active->raw();
    }

    /**
     * @return VO\Option\Check
     */
    public function getActive(): VO\Option\Check
    {
        return $this->active;
    }

    /**
     * @param VO\Option\Check $active
     *
     * @return Country
     */
    public function setActive(VO\Option\Check $active): Country
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string
     */
    public function vatRate(): string
    {
        return $this->vatRate->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getVatRate(): VO\Identity\Uuid
    {
        return $this->vatRate;
    }

    /**
     * @param VO\Identity\Uuid $vatRate
     *
     * @return Country
     */
    public function setVatRate(VO\Identity\Uuid $vatRate): Country
    {
        $this->vatRate = $vatRate;

        return $this;
    }
}

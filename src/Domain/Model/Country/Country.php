<?php

namespace N3ttech\Intl\Domain\Model\Country;

use N3ttech\Intl\Application\Country\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Country extends AggregateRoot
{
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
     * @param VO\Intl\Country\Code $code
     *
     * @return Country
     */
    public function setCode(VO\Intl\Country\Code $code): Country
    {
        $this->setAggregateId($code);

        return $this;
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
     * @param VO\Identity\Uuid $vatRate
     *
     * @return Country
     */
    public function setVatRate(VO\Identity\Uuid $vatRate): Country
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * @param VO\Intl\Country\Code   $code
     * @param VO\Intl\Continent\Code $continent
     * @param VO\Identity\Uuid       $vatRate
     * @param VO\Char\Text           $dateFormat
     * @param VO\Char\Text           $timeFormat
     *
     * @return Country
     */
    public static function createNewCountry(
        VO\Intl\Country\Code $code,
        VO\Intl\Continent\Code $continent,
        VO\Identity\Uuid $vatRate,
        VO\Char\Text $dateFormat,
        VO\Char\Text $timeFormat
    ): Country {
        $country = new static();

        $country->recordThat(Event\NewCountryCreated::occur($code->toString(), [
            'continent' => $continent->toString(),
            'vat_rate' => $vatRate->toString(),
            'date_format' => $dateFormat->toString(),
            'time_format' => $timeFormat->toString(),
        ]));

        return $country;
    }

    /**
     * @param VO\Intl\Continent\Code $continent
     * @param VO\Identity\Uuid       $vatRate
     * @param VO\Char\Text           $dateFormat
     * @param VO\Char\Text           $timeFormat
     */
    public function update(
        VO\Intl\Continent\Code $continent,
        VO\Identity\Uuid $vatRate,
        VO\Char\Text $dateFormat,
        VO\Char\Text $timeFormat
    ): void {
        $this->recordThat(Event\ExistingCountryUpdated::occur($this->aggregateId(), [
            'continent' => $continent->toString(),
            'vat_rate' => $vatRate->toString(),
            'date_format' => $dateFormat->toString(),
            'time_format' => $timeFormat->toString(),
        ]));
    }

    public function activate(): void
    {
        $this->recordThat(Event\ExistingCountryActivated::occur($this->aggregateId()));
    }

    public function deactivate(): void
    {
        $this->recordThat(Event\ExistingCountryDeactivated::occur($this->aggregateId()));
    }

    /**
     * @param VO\Intl\Currency\Codes $currensies
     * @param VO\Intl\Language\Codes $languages
     */
    public function internationalize(
        VO\Intl\Currency\Codes $currensies,
        VO\Intl\Language\Codes $languages
    ): void {
        $this->recordThat(Event\ExistingCountryInternationalized::occur($this->aggregateId(), [
            'currencies' => $currensies->raw(),
            'languages' => $languages->raw(),
        ]));
    }

    /**
     * @param VO\Intl\Country\Regions $regions
     */
    public function regionize(VO\Intl\Country\Regions $regions): void
    {
        $this->recordThat(Event\ExistingCountryRegionized::occur($this->aggregateId(), [
            'regions' => $regions->raw(),
        ]));
    }

    /**
     * @param VO\Intl\Language\Locales $names
     */
    public function translate(VO\Intl\Language\Locales $names): void
    {
        $this->recordThat(Event\ExistingCountryTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingCountryRemoved::occur($this->aggregateId()));
    }
}

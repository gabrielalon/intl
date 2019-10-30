<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCountryUpdated extends CountryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Continent\Code
     */
    public function countryContinent(): VO\Intl\Continent\Code
    {
        return VO\Intl\Continent\Code::fromCode((string) $this->payload['continent'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function countryDateFormat(): VO\Char\Text
    {
        return VO\Char\Text::fromString((string) $this->payload['date_format'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function countryTimeFormat(): VO\Char\Text
    {
        return VO\Char\Text::fromString((string) $this->payload['time_format'] ?? '');
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuid
     */
    public function countryVatRate(): VO\Identity\Uuid
    {
        return VO\Identity\Uuid::fromIdentity($this->payload['vat_rate'] ?? '');
    }

    /**
     * @param Country $country
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $country): void
    {
        $country->setCode($this->countryCode());
        $country->setContinent($this->countryContinent());
        $country->setDateFormat($this->countryDateFormat());
        $country->setTimeFormat($this->countryTimeFormat());
        $country->setVatRate($this->countryVatRate());
    }
}

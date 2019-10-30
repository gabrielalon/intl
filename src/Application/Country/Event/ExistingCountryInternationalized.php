<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCountryInternationalized extends CountryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Currency\Codes
     */
    public function countryCurrencies(): VO\Intl\Currency\Codes
    {
        return VO\Intl\Currency\Codes::fromArray($this->payload['currencies'] ?? []);
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Codes
     */
    public function countryLanguages(): VO\Intl\Language\Codes
    {
        return VO\Intl\Language\Codes::fromArray($this->payload['languages'] ?? []);
    }

    /**
     * @param Country $country
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $country): void
    {
        $country->setCode($this->countryCode());
        $country->setCurrencies($this->countryCurrencies());
        $country->setLanguages($this->countryLanguages());
    }
}

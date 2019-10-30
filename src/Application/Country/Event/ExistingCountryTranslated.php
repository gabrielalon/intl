<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCountryTranslated extends CountryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Locales
     */
    public function countryNames(): VO\Intl\Language\Locales
    {
        return VO\Intl\Language\Locales::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @param Country $country
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $country): void
    {
        $country->setCode($this->countryCode());
        $country->setNames($this->countryNames());
    }
}

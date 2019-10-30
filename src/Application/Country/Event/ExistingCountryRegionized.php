<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCountryRegionized extends CountryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Country\Regions
     */
    public function countryRegions(): VO\Intl\Country\Regions
    {
        return VO\Intl\Country\Regions::fromArray($this->payload['regions'] ?? []);
    }

    /**
     * @param Country $country
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $country): void
    {
        $country->setCode($this->countryCode());
        $country->setRegions($this->countryRegions());
    }
}

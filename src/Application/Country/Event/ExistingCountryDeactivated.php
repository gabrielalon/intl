<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingCountryDeactivated extends CountryEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Option\Check
     */
    public function countryActive(): VO\Option\Check
    {
        return VO\Option\Check::fromBoolean(false);
    }

    /**
     * @param Country $country
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $country): void
    {
        $country->setCode($this->countryCode());
        $country->setActive($this->countryActive());
    }
}

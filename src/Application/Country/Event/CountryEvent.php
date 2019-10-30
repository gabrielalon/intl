<?php

namespace N3ttech\Intl\Application\Country\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class CountryEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Country\Code
     */
    public function countryCode(): VO\Intl\Country\Code
    {
        return VO\Intl\Country\Code::fromCode($this->aggregateId());
    }
}

<?php

namespace N3ttech\Intl\Application\Continent\Event;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingContinentRemoved extends ContinentEvent
{
    /**
     * @param Continent $continent
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $continent): void
    {
        $continent->setCode($this->continentCode());
    }
}

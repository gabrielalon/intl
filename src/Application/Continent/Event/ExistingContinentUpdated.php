<?php

namespace N3ttech\Intl\Application\Continent\Event;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingContinentUpdated extends ContinentEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Locales
     */
    public function continentNames(): VO\Intl\Locales
    {
        return VO\Intl\Locales::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @param Continent $continent
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $continent): void
    {
        $continent->setCode($this->continentCode());
        $continent->setNames($this->continentNames());
    }
}
<?php

namespace N3ttech\Intl\Application\Continent\Event;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;

abstract class ContinentEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return Continent\Code
     */
    public function continentCode(): Continent\Code
    {
        return Continent\Code::fromString($this->aggregateId());
    }
}

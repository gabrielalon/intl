<?php

namespace N3ttech\Intl\Application\Continent\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class ContinentEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Continent\Code
     */
    public function continentCode(): VO\Intl\Continent\Code
    {
        return VO\Intl\Continent\Code::fromCode($this->aggregateId());
    }
}

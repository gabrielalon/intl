<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class SiteEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuid
     */
    public function siteUuid(): VO\Identity\Uuid
    {
        return VO\Identity\Uuid::fromIdentity($this->aggregateId());
    }
}

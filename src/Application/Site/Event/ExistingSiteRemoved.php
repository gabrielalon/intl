<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingSiteRemoved extends SiteEvent
{
    /**
     * @param Site $site
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $site): void
    {
        $site->setUuid($this->siteUuid());
    }
}

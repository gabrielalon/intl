<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class CountriesToSiteAssigned extends SiteEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Country\Codes
     */
    public function siteCountries(): VO\Intl\Country\Codes
    {
        return VO\Intl\Country\Codes::fromArray($this->payload['countries'] ?? []);
    }

    /**
     * @param Site $site
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $site): void
    {
        $site->setUuid($this->siteUuid());
        $site->setCountries($this->siteCountries());
    }
}

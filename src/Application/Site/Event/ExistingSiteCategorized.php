<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingSiteCategorized extends SiteEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function siteCategories(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['categories'] ?? []);
    }

    /**
     * @param Site $site
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $site): void
    {
        $site->setUuid($this->siteUuid());
        $site->setCategories($this->siteCategories());
    }
}

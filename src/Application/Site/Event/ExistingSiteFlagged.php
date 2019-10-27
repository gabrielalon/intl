<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingSiteFlagged extends SiteEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Option\Check
     */
    public function siteMobile(): VO\Option\Check
    {
        return VO\Option\Check::fromBoolean((bool) ($this->payload['mobile'] ?? ''));
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Option\Check
     */
    public function siteAuth(): VO\Option\Check
    {
        return VO\Option\Check::fromBoolean((bool) ($this->payload['auth'] ?? ''));
    }

    /**
     * @param Site $site
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $site): void
    {
        $site->setUuid($this->siteUuid());
        $site->setMobile($this->siteMobile());
        $site->setAuth($this->siteAuth());
    }
}

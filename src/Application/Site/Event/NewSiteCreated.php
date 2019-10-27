<?php

namespace N3ttech\Intl\Application\Site\Event;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class NewSiteCreated extends ExistingSiteFlagged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Char\Text
     */
    public function siteHost(): VO\Char\Text
    {
        return VO\Char\Text::fromString((string) ($this->payload['host'] ?? ''));
    }

    /**
     * @param Site $site
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $site): void
    {
        $site->setUuid($this->siteUuid());
        $site->setHost($this->siteHost());
        $site->setMobile($this->siteMobile());
        $site->setAuth($this->siteAuth());
    }
}

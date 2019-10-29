<?php

namespace N3ttech\Intl\Domain\Model\Site\Projection;

use N3ttech\Intl\Application\Site\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface SiteProjection extends EventProjector
{
    /**
     * @param Event\NewSiteCreated $event
     */
    public function onNewSiteCreated(Event\NewSiteCreated $event): void;

    /**
     * @param Event\ExistingSiteFlagged $event
     */
    public function onExistingSiteFlagged(Event\ExistingSiteFlagged $event): void;

    /**
     * @param Event\CountriesToSiteAssigned $event
     */
    public function onCountriesToSiteAssigned(Event\CountriesToSiteAssigned $event): void;

    /**
     * @param Event\ExistingSiteRemoved $event
     */
    public function onExistingSiteRemoved(Event\ExistingSiteRemoved $event): void;
}

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
     * @param Event\NewSiteCreated $event
     */
    public function onExistingSiteFlagged(Event\ExistingSiteFlagged $event): void;

    /**
     * @param Event\ExistingSiteCategorized $event
     */
    public function onExistingSiteCategorized(Event\ExistingSiteCategorized $event): void;

    /**
     * @param Event\ExistingSiteRemoved $event
     */
    public function onExistingSiteRemoved(Event\ExistingSiteRemoved $event): void;
}

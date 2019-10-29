<?php

namespace N3ttech\Intl\Domain\Model\Continent\Projection;

use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface ContinentProjection extends EventProjector
{
    /**
     * @param Event\NewContinentCreated $event
     */
    public function onNewContinentCreated(Event\NewContinentCreated $event): void;

    /**
     * @param Event\ExistingContinentTranslated $event
     */
    public function onExistingContinentTranslated(Event\ExistingContinentTranslated $event): void;

    /**
     * @param Event\ExistingContinentRemoved $event
     */
    public function onExistingContinentRemoved(Event\ExistingContinentRemoved $event): void;
}

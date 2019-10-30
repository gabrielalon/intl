<?php

namespace N3ttech\Intl\Domain\Model\Country\Projection;

use N3ttech\Intl\Application\Country\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface CountryProjection extends EventProjector
{
    /**
     * @param Event\NewCountryCreated $event
     */
    public function onNewCountryCreated(Event\NewCountryCreated $event): void;

    /**
     * @param Event\ExistingCountryUpdated $event
     */
    public function onExistingCountryUpdated(Event\ExistingCountryUpdated $event): void;

    /**
     * @param Event\ExistingCountryTranslated $event
     */
    public function onExistingCountryTranslated(Event\ExistingCountryTranslated $event): void;

    /**
     * @param Event\ExistingCountryActivated $event
     */
    public function onExistingCountryActivated(Event\ExistingCountryActivated $event): void;

    /**
     * @param Event\ExistingCountryDeactivated $event
     */
    public function onExistingCountryDeactivated(Event\ExistingCountryDeactivated $event): void;

    /**
     * @param Event\ExistingCountryInternationalized $event
     */
    public function onExistingCountryInternationalized(Event\ExistingCountryInternationalized $event): void;

    /**
     * @param Event\ExistingCountryRegionized $event
     */
    public function onExistingCountryRegionized(Event\ExistingCountryRegionized $event): void;

    /**
     * @param Event\ExistingCountryRemoved $event
     */
    public function onExistingCountryRemoved(Event\ExistingCountryRemoved $event): void;
}

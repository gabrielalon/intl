<?php

namespace N3ttech\Intl\Domain\Model\VatRate\Projection;

use N3ttech\Intl\Application\VatRate\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface VatRateProjection extends EventProjector
{
    /**
     * @param Event\NewVatRateCreated $event
     */
    public function onNewVatRateCreated(Event\NewVatRateCreated $event): void;

    /**
     * @param Event\ExistingVatRateTranslated $event
     */
    public function onExistingVatRateTranslated(Event\ExistingVatRateTranslated $event): void;

    /**
     * @param Event\ExistingVatRateRefreshed $event
     */
    public function onExistingVatRateRefreshed(Event\ExistingVatRateRefreshed $event): void;

    /**
     * @param Event\ExistingVatRateRemoved $event
     */
    public function onExistingVatRateRemoved(Event\ExistingVatRateRemoved $event): void;
}

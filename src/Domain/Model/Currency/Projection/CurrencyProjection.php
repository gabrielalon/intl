<?php

namespace N3ttech\Intl\Domain\Model\Currency\Projection;

use N3ttech\Intl\Application\Currency\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface CurrencyProjection extends EventProjector
{
    /**
     * @param Event\NewCurrencyCreated $event
     */
    public function onNewCurrencyCreated(Event\NewCurrencyCreated $event): void;

    /**
     * @param Event\ExistingCurrencyUpdated $event
     */
    public function onExistingCurrencyUpdated(Event\ExistingCurrencyUpdated $event): void;

    /**
     * @param Event\ExistingCurrencyTranslated $event
     */
    public function onExistingCurrencyTranslated(Event\ExistingCurrencyTranslated $event): void;

    /**
     * @param Event\ExistingCurrencyRefreshed $event
     */
    public function onExistingCurrencyRefreshed(Event\ExistingCurrencyRefreshed $event): void;

    /**
     * @param Event\ExistingCurrencyRemoved $event
     */
    public function onExistingCurrencyRemoved(Event\ExistingCurrencyRemoved $event): void;
}

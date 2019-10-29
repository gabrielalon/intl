<?php

namespace N3ttech\Intl\Domain\Model\Language\Projection;

use N3ttech\Intl\Application\Language\Event;
use N3ttech\Messaging\Message\EventSourcing\EventProjector;

interface LanguageProjection extends EventProjector
{
    /**
     * @param Event\NewLanguageCreated $event
     */
    public function onNewLanguageCreated(Event\NewLanguageCreated $event): void;

    /**
     * @param Event\ExistingLanguageTranslated $event
     */
    public function onExistingLanguageTranslated(Event\ExistingLanguageTranslated $event): void;

    /**
     * @param Event\ExistingLanguageRemoved $event
     */
    public function onExistingLanguageRemoved(Event\ExistingLanguageRemoved $event): void;
}

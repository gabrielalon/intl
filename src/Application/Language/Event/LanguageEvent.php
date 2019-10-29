<?php

namespace N3ttech\Intl\Application\Language\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class LanguageEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Locale
     */
    public function languageLocale(): VO\Intl\Language\Locale
    {
        return VO\Intl\Language\Locale::fromLocale($this->aggregateId());
    }
}

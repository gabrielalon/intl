<?php

namespace N3ttech\Intl\Application\Language\Event;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingLanguageRemoved extends LanguageEvent
{
    /**
     * @param Language $language
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $language): void
    {
        $language->setLocale($this->languageLocale());
    }
}

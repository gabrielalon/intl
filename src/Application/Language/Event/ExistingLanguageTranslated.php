<?php

namespace N3ttech\Intl\Application\Language\Event;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingLanguageTranslated extends LanguageEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Locales
     */
    public function languageNames(): VO\Intl\Language\Locales
    {
        return VO\Intl\Language\Locales::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @param Language $language
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $language): void
    {
        $language->setLocale($this->languageLocale());
        $language->setNames($this->languageNames());
    }
}

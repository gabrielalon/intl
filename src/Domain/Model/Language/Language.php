<?php

namespace N3ttech\Intl\Domain\Model\Language;

use N3ttech\Intl\Application\Language\Event;
use N3ttech\Messaging\Aggregate;
use N3ttech\Valuing as VO;

class Language extends Aggregate\AggregateRoot
{
    /** @var VO\Intl\Language\Texts */
    private $names;

    /**
     * @param VO\Intl\Language\Code $locale
     *
     * @return Language
     */
    public function setLocale(VO\Intl\Language\Code $locale): Language
    {
        $this->setAggregateId($locale);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Language
     */
    public function setNames(VO\Intl\Language\Texts $names): Language
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Code  $locale
     * @param VO\Intl\Language\Texts $names
     *
     * @return Language
     */
    public static function createNewLanguage(VO\Intl\Language\Code $locale, VO\Intl\Language\Texts $names): Language
    {
        $continent = new static();

        $continent->recordThat(Event\NewLanguageCreated::occur($locale->toString(), [
            'names' => $names->raw(),
        ]));

        return $continent;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     */
    public function translate(VO\Intl\Language\Texts $names): void
    {
        $this->recordThat(Event\ExistingLanguageTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingLanguageRemoved::occur($this->aggregateId()));
    }
}

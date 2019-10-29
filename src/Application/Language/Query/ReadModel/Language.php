<?php

namespace N3ttech\Intl\Application\Language\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Language implements Viewable
{
    /** @var VO\Intl\Language\Locale */
    private $locale;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /**
     * @param string $locale
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Language
     */
    public static function fromLocale(string $locale): Language
    {
        $site = new static();

        return $site->setLocale(VO\Intl\Language\Locale::fromLocale($locale));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->locale->toString();
    }

    /**
     * @return VO\Intl\Language\Locale
     */
    public function getLocale(): VO\Intl\Language\Locale
    {
        return $this->locale;
    }

    /**
     * @param VO\Intl\Language\Locale $locale
     *
     * @return Language
     */
    public function setLocale(VO\Intl\Language\Locale $locale): Language
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return VO\Intl\Language\Locales
     */
    public function getNames(): VO\Intl\Language\Locales
    {
        return $this->names;
    }

    /**
     * @param string $locale
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return string
     */
    public function name(string $locale): string
    {
        return $this->names->getLocale($locale)->toString();
    }

    /**
     * @return array
     */
    public function names(): array
    {
        return $this->names->raw();
    }

    /**
     * @param VO\Intl\Language\Locales $names
     *
     * @return Language
     */
    public function setNames(VO\Intl\Language\Locales $names): Language
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param string $locale
     * @param string $name
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Language
     */
    public function addName(string $locale, string $name): Language
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }
}

<?php

namespace N3ttech\Intl\Application\Continent\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Continent implements Viewable
{
    /** @var VO\Intl\Continent\Code */
    private $code;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Continent
     */
    public static function fromCode(string $code): Continent
    {
        $site = new static();

        return $site->setCode(VO\Intl\Continent\Code::fromCode($code));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->code->toString();
    }

    /**
     * @return VO\Intl\Continent\Code
     */
    public function getCode(): VO\Intl\Continent\Code
    {
        return $this->code;
    }

    /**
     * @param VO\Intl\Continent\Code $code
     *
     * @return Continent
     */
    public function setCode(VO\Intl\Continent\Code $code): Continent
    {
        $this->code = $code;

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
     * @return Continent
     */
    public function setNames(VO\Intl\Language\Locales $names): Continent
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
     * @return \N3ttech\Intl\Application\Continent\Query\ReadModel\Continent
     */
    public function addName(string $locale, string $name): Continent
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }
}

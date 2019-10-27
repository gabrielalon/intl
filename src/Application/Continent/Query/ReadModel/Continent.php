<?php

namespace N3ttech\Intl\Application\Continent\Query\ReadModel;

use N3ttech\Intl\Domain\Model\Continent\Continent\Code;
use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Continent implements Viewable
{
    /** @var Code */
    private $code;

    /** @var VO\Intl\Locales */
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

        return $site->setCode(Code::fromString($code));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->code->toString();
    }

    /**
     * @return Code
     */
    public function getCode(): Code
    {
        return $this->code;
    }

    /**
     * @param Code $code
     *
     * @return Continent
     */
    public function setCode(Code $code): Continent
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return VO\Intl\Locales
     */
    public function getNames(): VO\Intl\Locales
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
     * @param VO\Intl\Locales $names
     *
     * @return Continent
     */
    public function setNames(VO\Intl\Locales $names): Continent
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
            $this->setNames(VO\Intl\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }
}

<?php

namespace N3ttech\Intl\Application\VatRate\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class VatRate implements Viewable
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Number\Decimal */
    private $rate;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return VatRate
     */
    public static function fromIdentity(string $uuid): VatRate
    {
        $vatRate = new static();

        return $vatRate->setUuid(VO\Identity\Uuid::fromIdentity($uuid));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getUuid(): VO\Identity\Uuid
    {
        return $this->uuid;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return VatRate
     */
    public function setUuid(VO\Identity\Uuid $uuid): VatRate
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return float
     */
    public function rate(): float
    {
        return $this->rate->raw();
    }

    /**
     * @return VO\Number\Decimal
     */
    public function getRate(): VO\Number\Decimal
    {
        return $this->rate;
    }

    /**
     * @param VO\Number\Decimal $rate
     *
     * @return VatRate
     */
    public function setRate(VO\Number\Decimal $rate): VatRate
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return array
     */
    public function names(): array
    {
        return $this->names->raw();
    }

    /**
     * @return VO\Intl\Language\Locales
     */
    public function getNames(): VO\Intl\Language\Locales
    {
        return $this->names;
    }

    /**
     * @param VO\Intl\Language\Locales $names
     *
     * @return VatRate
     */
    public function setNames(VO\Intl\Language\Locales $names): VatRate
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
     * @return VatRate
     */
    public function addName(string $locale, string $name): VatRate
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Locales::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }
}

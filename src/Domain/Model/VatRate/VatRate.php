<?php

namespace N3ttech\Intl\Domain\Model\VatRate;

use N3ttech\Intl\Application\VatRate\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class VatRate extends AggregateRoot
{
    /** @var VO\Number\Decimal */
    private $rate;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return VatRate
     */
    public function setUuid(VO\Identity\Uuid $uuid): VatRate
    {
        $this->setAggregateId($uuid);

        return $this;
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
     * @param VO\Intl\Language\Texts $names
     *
     * @return VatRate
     */
    public function setNames(VO\Intl\Language\Texts $names): VatRate
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid         $uuid
     * @param VO\Number\Decimal        $rate
     * @param VO\Intl\Language\Texts $names
     *
     * @return VatRate
     */
    public static function createNewVatRate(
        VO\Identity\Uuid $uuid,
        VO\Number\Decimal $rate,
        VO\Intl\Language\Texts $names
    ): VatRate {
        $site = new VatRate();

        $site->recordThat(Event\NewVatRateCreated::occur($uuid->toString(), [
            'rate' => $rate->raw(),
            'names' => $names->raw(),
        ]));

        return $site;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     */
    public function translate(VO\Intl\Language\Texts $names): void
    {
        $this->recordThat(Event\ExistingVatRateTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    /**
     * @param VO\Number\Decimal $rate
     */
    public function refresh(VO\Number\Decimal $rate): void
    {
        $this->recordThat(Event\ExistingVatRateRefreshed::occur($this->aggregateId(), [
            'rate' => $rate->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingVatRateRemoved::occur($this->aggregateId()));
    }
}

<?php

namespace N3ttech\Intl\Application\VatRate\Event;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class NewVatRateCreated extends VatRateEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Language\Texts
     */
    public function vatRateNames(): VO\Intl\Language\Texts
    {
        return VO\Intl\Language\Texts::fromArray($this->payload['names'] ?? []);
    }

    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Number\Decimal
     */
    public function vatRateRate(): VO\Number\Decimal
    {
        return VO\Number\Decimal::fromFloat((float) ($this->payload['rate'] ?? 0.0));
    }

    /**
     * @param VatRate $vatRate
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $vatRate): void
    {
        $vatRate->setUuid($this->vatRateUuid());
        $vatRate->setNames($this->vatRateNames());
        $vatRate->setRate($this->vatRateRate());
    }
}

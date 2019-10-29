<?php

namespace N3ttech\Intl\Application\VatRate\Event;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingVatRateRefreshed extends VatRateEvent
{
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
        $vatRate->setRate($this->vatRateRate());
    }
}

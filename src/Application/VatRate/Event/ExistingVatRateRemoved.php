<?php

namespace N3ttech\Intl\Application\VatRate\Event;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Aggregate\AggregateRoot;

class ExistingVatRateRemoved extends VatRateEvent
{
    /**
     * @param VatRate $vatRate
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $vatRate): void
    {
        $vatRate->setUuid($this->vatRateUuid());
    }
}

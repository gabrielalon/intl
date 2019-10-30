<?php

namespace N3ttech\Intl\Application\VatRate\Event;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class ExistingVatRateTranslated extends VatRateEvent
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
     * @param VatRate $vatRate
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $vatRate): void
    {
        $vatRate->setUuid($this->vatRateUuid());
        $vatRate->setNames($this->vatRateNames());
    }
}

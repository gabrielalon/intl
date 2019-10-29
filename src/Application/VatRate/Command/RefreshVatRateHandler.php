<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class RefreshVatRateHandler extends VatRateHandler
{
    /**
     * @param RefreshVatRate $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->repository->find($command->getUuid());

        $vatRate->refresh(VO\Number\Decimal::fromFloat($command->getRate()));

        $this->repository->save($vatRate);
    }
}

<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Message\Domain\Message;

class RemoveVatRateHandler extends VatRateHandler
{
    /**
     * @param RemoveVatRate $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->repository->find($command->getUuid());

        $vatRate->remove();

        $this->repository->save($vatRate);
    }
}

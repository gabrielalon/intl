<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateVatRateHandler extends VatRateHandler
{
    /**
     * @param CreateVatRate $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(VatRate::createNewVatRate(
            VO\Identity\Uuid::fromIdentity($command->getUuid()),
            VO\Number\Decimal::fromFloat($command->getRate()),
            VO\Intl\Language\Texts::fromArray($command->getNames())
        ));
    }
}

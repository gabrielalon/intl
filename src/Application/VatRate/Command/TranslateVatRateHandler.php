<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateVatRateHandler extends VatRateHandler
{
    /**
     * @param TranslateVatRate $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->repository->find($command->getUuid());

        $vatRate->translate(VO\Intl\Language\Locales::fromArray($command->getNames()));

        $this->repository->save($vatRate);
    }
}

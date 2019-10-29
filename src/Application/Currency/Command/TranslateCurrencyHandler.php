<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateCurrencyHandler extends CurrencyHandler
{
    /**
     * @param TranslateCurrency $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Currency $currency */
        $currency = $this->repository->find($command->getCode());

        $currency->translate(VO\Intl\Language\Locales::fromArray($command->getNames()));

        $this->repository->save($currency);
    }
}

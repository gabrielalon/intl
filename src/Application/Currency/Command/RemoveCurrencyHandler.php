<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Message\Domain\Message;

class RemoveCurrencyHandler extends CurrencyHandler
{
    /**
     * @param RemoveCurrency $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Currency $currency */
        $currency = $this->repository->find($command->getCode());

        $currency->remove();

        $this->repository->save($currency);
    }
}

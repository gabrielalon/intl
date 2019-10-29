<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class UpdateCurrencyHandler extends CurrencyHandler
{
    /**
     * @param UpdateCurrency $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Currency $currency */
        $currency = $this->repository->find($command->getCode());

        $currency->update(
            VO\Char\Text::fromString($command->getSymbol()),
            VO\Char\Text::fromString($command->getPriceFormat())
        );

        $this->repository->save($currency);
    }
}

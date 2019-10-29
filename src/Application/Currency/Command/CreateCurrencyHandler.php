<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateCurrencyHandler extends CurrencyHandler
{
    /**
     * @param CreateCurrency $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Currency::createNewCurrency(
            VO\Intl\Currency\Code::fromCode($command->getCode()),
            VO\Char\Text::fromString($command->getSymbol()),
            VO\Char\Text::fromString($command->getPriceFormat())
        ));
    }
}

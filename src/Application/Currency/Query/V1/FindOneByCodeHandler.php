<?php

namespace N3ttech\Intl\Application\Currency\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindOneByCodeHandler extends CurrencyQueryHandler
{
    /**
     * @param FindOneByCode $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByCode($query);
    }
}

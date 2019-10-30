<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindOneByCodeHandler extends CountryQueryHandler
{
    /**
     * @param FindOneByCode $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByCode($query);
    }
}

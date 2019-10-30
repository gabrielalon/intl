<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindAllActiveHandler extends CountryQueryHandler
{
    /**
     * @param FindAllActive $query
     */
    public function run(Message $query): void
    {
        $this->ask->findAllActive($query);
    }
}

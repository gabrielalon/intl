<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindOneByHostHandler extends SiteQueryHandler
{
    /**
     * @param FindOneByHost $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByHost($query);
    }
}

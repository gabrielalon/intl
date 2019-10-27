<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;

class FindOneByIdentityHandler extends SiteQueryHandler
{
    /**
     * @param FindOneByIdentity $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByIdentity($query);
    }
}

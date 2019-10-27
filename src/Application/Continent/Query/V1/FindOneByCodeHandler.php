<?php

namespace N3ttech\Intl\Application\Continent\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

class FindOneByCodeHandler implements QueryHandler
{
    /** @var ContinentQuery */
    private $ask;

    /**
     * @param ContinentQuery $ask
     */
    public function __construct(ContinentQuery $ask)
    {
        $this->ask = $ask;
    }

    /**
     * @param FindOneByCode $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByCode($query);
    }
}

<?php

namespace N3ttech\Intl\Application\Language\Query\V1;

use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

class FindOneByLocaleHandler implements QueryHandler
{
    /** @var LanguageQuery */
    private $ask;

    /**
     * @param LanguageQuery $ask
     */
    public function __construct(LanguageQuery $ask)
    {
        $this->ask = $ask;
    }

    /**
     * @param FindOneByLocale $query
     */
    public function run(Message $query): void
    {
        $this->ask->findOneByLocale($query);
    }
}

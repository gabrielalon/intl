<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Intl\Infrastructure\Persist\Currency\CurrencyRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class CurrencyHandler implements CommandHandler
{
    /** @var CurrencyRepository */
    protected $repository;

    /**
     * @param CurrencyRepository $repository
     */
    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }
}

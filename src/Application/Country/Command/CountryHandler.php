<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Infrastructure\Persist\Country\CountryRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class CountryHandler implements CommandHandler
{
    /** @var CountryRepository */
    protected $repository;

    /**
     * @param CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }
}

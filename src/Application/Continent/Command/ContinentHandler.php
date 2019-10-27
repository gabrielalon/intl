<?php

namespace N3ttech\Intl\Application\Continent\Command;

use N3ttech\Intl\Infrastructure\Persist\Continent\ContinentRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class ContinentHandler implements CommandHandler
{
    /** @var ContinentRepository */
    protected $repository;

    /**
     * @param ContinentRepository $repository
     */
    public function __construct(ContinentRepository $repository)
    {
        $this->repository = $repository;
    }
}

<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Intl\Infrastructure\Persist\Site\SiteRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class SiteHandler implements CommandHandler
{
    /** @var SiteRepository */
    protected $repository;

    /**
     * @param SiteRepository $repository
     */
    public function __construct(SiteRepository $repository)
    {
        $this->repository = $repository;
    }
}

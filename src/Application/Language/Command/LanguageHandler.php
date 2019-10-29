<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Intl\Infrastructure\Persist\Language\LanguageRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class LanguageHandler implements CommandHandler
{
    /** @var LanguageRepository */
    protected $repository;

    /**
     * @param LanguageRepository $repository
     */
    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }
}

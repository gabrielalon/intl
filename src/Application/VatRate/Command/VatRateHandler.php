<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Intl\Infrastructure\Persist\VatRate\VatRateRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class VatRateHandler implements CommandHandler
{
    /** @var VatRateRepository */
    protected $repository;

    /**
     * @param VatRateRepository $repository
     */
    public function __construct(VatRateRepository $repository)
    {
        $this->repository = $repository;
    }
}

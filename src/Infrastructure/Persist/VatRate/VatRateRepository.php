<?php

namespace N3ttech\Intl\Infrastructure\Persist\VatRate;

use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing\Identity\Uuid;

class VatRateRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return VatRate::class;
    }

    /**
     * @param VatRate $site
     *
     * @throws \Exception
     */
    public function save(VatRate $site): void
    {
        $this->saveAggregateRoot($site);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|VatRate
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(Uuid::fromIdentity($uuid));
    }
}

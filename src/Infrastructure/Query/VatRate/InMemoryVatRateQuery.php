<?php

namespace N3ttech\Intl\Infrastructure\Query\VatRate;

use N3ttech\Intl\Application\VatRate\Query;

class InMemoryVatRateQuery implements Query\V1\VatRateQuery
{
    /** @var Query\ReadModel\VatRateCollection */
    private $entities;

    /**
     * @param Query\ReadModel\VatRateCollection $entities
     */
    public function __construct(Query\ReadModel\VatRateCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByIdentity $query
     */
    public function findOneByIdentity(Query\V1\FindOneByIdentity $query): void
    {
        $this->checkExistence($query->getUuid());

        $query->setVatRate($this->entities->get($query->getUuid()));
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('VatRate does not exists on given identity: %s', $uuid));
        }
    }
}

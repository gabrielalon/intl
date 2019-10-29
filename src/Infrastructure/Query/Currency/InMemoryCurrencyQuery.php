<?php

namespace N3ttech\Intl\Infrastructure\Query\Currency;

use N3ttech\Intl\Application\Currency\Query;

class InMemoryCurrencyQuery implements Query\V1\CurrencyQuery
{
    /** @var Query\ReadModel\CurrencyCollection */
    private $entities;

    /**
     * @param Query\ReadModel\CurrencyCollection $entities
     */
    public function __construct(Query\ReadModel\CurrencyCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByCode $query
     */
    public function findOneByCode(Query\V1\FindOneByCode $query): void
    {
        $this->checkExistence($query->getCode());

        $query->setCurrency($this->entities->get($query->getCode()));
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf(
                'Currency does not exists on given code: %s',
                $uuid
            ));
        }
    }
}

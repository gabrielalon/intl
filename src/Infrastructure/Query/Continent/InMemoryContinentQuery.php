<?php

namespace N3ttech\Intl\Infrastructure\Query\Continent;

use N3ttech\Intl\Application\Continent\Query;

class InMemoryContinentQuery implements Query\V1\ContinentQuery
{
    /** @var Query\ReadModel\ContinentCollection */
    private $entities;

    /**
     * @param Query\ReadModel\ContinentCollection $entities
     */
    public function __construct(Query\ReadModel\ContinentCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByCode $query
     */
    public function findOneByCode(Query\V1\FindOneByCode $query): void
    {
        $this->checkExistence($query->getCode());

        $query->setContinent($this->entities->get($query->getCode()));
    }

    /**
     * @param string $code
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $code): void
    {
        if (false === $this->entities->has($code)) {
            throw new \RuntimeException(\sprintf(
                'Continent does not exists on given code: %s',
                $code
            ));
        }
    }
}

<?php

namespace N3ttech\Intl\Infrastructure\Query\Country;

use N3ttech\Intl\Application\Country\Query;

class InMemoryCountryQuery implements Query\V1\CountryQuery
{
    /** @var Query\ReadModel\CountryCollection */
    private $entities;

    /**
     * @param Query\ReadModel\CountryCollection $entities
     */
    public function __construct(Query\ReadModel\CountryCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByCode $query
     */
    public function findOneByCode(Query\V1\FindOneByCode $query): void
    {
        $this->checkExistence($query->getCode());

        $query->setCountry($this->entities->get($query->getCode()));
    }

    /**
     * @param Query\V1\FindAllActive $query
     */
    public function findAllActive(Query\V1\FindAllActive $query): void
    {
        $collection = new Query\ReadModel\CountryCollection();

        $filter = new Filter\ActiveIterator($this->entities);
        $filter->rewind();

        while ($filter->valid()) {
            /** @var Query\ReadModel\Country $country */
            $country = $filter->current();

            $collection->add($country);
            $filter->next();
        }

        $query->setCollection($collection);
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('Country does not exists on given code: %s', $uuid));
        }
    }
}

<?php

namespace N3ttech\Intl\Infrastructure\Persist\Continent;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;

class ContinentRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Continent::class;
    }

    /**
     * @param Continent $continent
     *
     * @throws \Exception
     */
    public function save(Continent $continent): void
    {
        $this->saveAggregateRoot($continent);
    }

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Continent
     */
    public function find(string $code): AggregateRoot
    {
        return $this->findAggregateRoot(Continent\Code::fromString($code));
    }
}

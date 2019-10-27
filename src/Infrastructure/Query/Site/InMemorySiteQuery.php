<?php

namespace N3ttech\Intl\Infrastructure\Query\Site;

use N3ttech\Intl\Application\Site\Query;

class InMemorySiteQuery implements Query\V1\SiteQuery
{
    /** @var Query\ReadModel\SiteCollection */
    private $entities;

    /**
     * @param Query\ReadModel\SiteCollection $entities
     */
    public function __construct(Query\ReadModel\SiteCollection $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @param Query\V1\FindOneByIdentity $query
     */
    public function findOneByIdentity(Query\V1\FindOneByIdentity $query): void
    {
        $this->checkExistence($query->getUuid());

        $query->setSite($this->entities->get($query->getUuid()));
    }

    /**
     * @param Query\V1\FindOneByHost $query
     *
     * @throws \Assert\AssertionFailedException
     */
    public function findOneByHost(Query\V1\FindOneByHost $query): void
    {
        $filter = new Filter\HostIterator($this->entities);
        $filter->setHost($query->getHost());
        $filter->rewind();

        while ($filter->valid()) {
            /** @var Query\ReadModel\Site $site */
            $site = $filter->current();
            $query->setSite($site);

            return;
        }

        throw new \RuntimeException(\sprintf(
            'Site does not exists on given host: %s',
            $query->getHost()
        ));
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
                'Site does not exists on given identity: %s',
                $uuid
            ));
        }
    }
}

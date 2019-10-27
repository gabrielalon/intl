<?php

namespace N3ttech\Intl\Infrastructure\Persist\Site;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing\Identity\Uuid;

class SiteRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Site::class;
    }

    /**
     * @param Site $site
     *
     * @throws \Exception
     */
    public function save(Site $site): void
    {
        $this->saveAggregateRoot($site);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Site
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(Uuid::fromIdentity($uuid));
    }
}

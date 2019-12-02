<?php

namespace N3ttech\Intl\Infrastructure\Projection\Site;

use N3ttech\Intl\Application\Site\Event;
use N3ttech\Intl\Application\Site\Query\ReadModel;
use N3ttech\Intl\Domain\Model\Site\Projection\SiteProjection;

class InMemorySiteProjector implements SiteProjection
{
    /** @var ReadModel\SiteCollection */
    private $entities;

    /**
     * @param ReadModel\SiteCollection|null $entities
     */
    public function __construct(ReadModel\SiteCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\SiteCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onNewSiteCreated(Event\NewSiteCreated $event): void
    {
        $this->entities->add(
            ReadModel\Site::fromIdentity($event->aggregateId())
                ->setHost($event->siteHost())
                ->setMobile($event->siteMobile())
                ->setAuth($event->siteAuth())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingSiteFlagged(Event\ExistingSiteFlagged $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setMobile($event->siteMobile())
            ->setAuth($event->siteAuth())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onCountriesToSiteAssigned(Event\CountriesToSiteAssigned $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setCountries($event->siteCountries())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function onExistingSiteRemoved(Event\ExistingSiteRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Site
     */
    public function get(string $uuid): ReadModel\Site
    {
        $this->checkExistence($uuid);

        return $this->entities->get($uuid);
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('Site does not exists on given identity: %s', $uuid));
        }
    }
}

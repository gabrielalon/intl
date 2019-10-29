<?php

namespace N3ttech\Intl\Infrastructure\Projection\VatRate;

use N3ttech\Intl\Application\VatRate\Event;
use N3ttech\Intl\Application\VatRate\Query\ReadModel;
use N3ttech\Intl\Domain\Model\VatRate\Projection\VatRateProjection;

class InMemoryVatRateProjector implements VatRateProjection
{
    /** @var ReadModel\VatRateCollection */
    private $entities;

    /**
     * @param null|ReadModel\VatRateCollection $entities
     */
    public function __construct(ReadModel\VatRateCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\VatRateCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onNewVatRateCreated(Event\NewVatRateCreated $event): void
    {
        $this->entities->add(
            ReadModel\VatRate::fromIdentity($event->aggregateId())
                ->setRate($event->vatRateRate())
                ->setNames($event->vatRateNames())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingVatRateRefreshed(Event\ExistingVatRateRefreshed $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setRate($event->vatRateRate())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingVatRateTranslated(Event\ExistingVatRateTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setNames($event->vatRateNames())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function onExistingVatRateRemoved(Event\ExistingVatRateRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\VatRate
     */
    public function get(string $uuid): ReadModel\VatRate
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
            throw new \RuntimeException(\sprintf(
                'VatRate does not exists on given identity: %s',
                $uuid
            ));
        }
    }
}

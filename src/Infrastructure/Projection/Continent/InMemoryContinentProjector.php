<?php

namespace N3ttech\Intl\Infrastructure\Projection\Continent;

use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Intl\Application\Continent\Query\ReadModel;
use N3ttech\Intl\Domain\Model\Continent\Projection;

class InMemoryContinentProjector implements Projection\ContinentProjection
{
    /** @var ReadModel\ContinentCollection */
    private $entities;

    /**
     * @param null|ReadModel\ContinentCollection $entities
     */
    public function __construct(ReadModel\ContinentCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\ContinentCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onNewContinentCreated(Event\NewContinentCreated $event): void
    {
        $this->entities->add(
            ReadModel\Continent::fromCode($event->aggregateId())
                ->setNames($event->continentNames())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingContinentUpdated(Event\ExistingContinentUpdated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $continent = $this->entities->get($event->aggregateId())
            ->setNames($event->continentNames())
        ;

        $this->entities->add($continent);
    }

    /**
     * {@inheritdoc}
     */
    public function onExistingContinentRemoved(Event\ExistingContinentRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $code
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Continent
     */
    public function get(string $code): ReadModel\Continent
    {
        $this->checkExistence($code);

        return $this->entities->get($code);
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

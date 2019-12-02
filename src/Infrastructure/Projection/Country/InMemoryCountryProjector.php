<?php

namespace N3ttech\Intl\Infrastructure\Projection\Country;

use N3ttech\Intl\Application\Country\Event;
use N3ttech\Intl\Application\Country\Query\ReadModel;
use N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection;

class InMemoryCountryProjector implements CountryProjection
{
    /** @var ReadModel\CountryCollection */
    private $entities;

    /**
     * @param ReadModel\CountryCollection|null $entities
     */
    public function __construct(ReadModel\CountryCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\CountryCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewCountryCreated(Event\NewCountryCreated $event): void
    {
        $this->entities->add(
            ReadModel\Country::fromCode($event->aggregateId())
                ->setContinent($event->countryContinent())
                ->setVatRate($event->countryVatRate())
                ->setDateFormat($event->countryDateFormat())
                ->setTimeFormat($event->countryTimeFormat())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingCountryUpdated(Event\ExistingCountryUpdated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setContinent($event->countryContinent())
            ->setVatRate($event->countryVatRate())
            ->setDateFormat($event->countryDateFormat())
            ->setTimeFormat($event->countryTimeFormat())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCountryTranslated(Event\ExistingCountryTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setNames($event->countryNames())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCountryActivated(Event\ExistingCountryActivated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setActive($event->countryActive())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCountryDeactivated(Event\ExistingCountryDeactivated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setActive($event->countryActive())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCountryInternationalized(Event\ExistingCountryInternationalized $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setCurrencies($event->countryCurrencies())
            ->setLanguages($event->countryLanguages())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCountryRegionized(Event\ExistingCountryRegionized $event): void
    {
        $this->checkExistence($event->aggregateId());

        $country = $this->entities->get($event->aggregateId())
            ->setRegions($event->countryRegions())
        ;

        $this->entities->add($country);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function onExistingCountryRemoved(Event\ExistingCountryRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $code
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Country
     */
    public function get(string $code): ReadModel\Country
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
            throw new \RuntimeException(\sprintf('Country does not exists on given code: %s', $code));
        }
    }
}

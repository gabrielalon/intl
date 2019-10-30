<?php

namespace N3ttech\Intl\Infrastructure\Projection\Currency;

use N3ttech\Intl\Application\Currency\Event;
use N3ttech\Intl\Application\Currency\Query\ReadModel;
use N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection;

class InMemoryCurrencyProjector implements CurrencyProjection
{
    /** @var ReadModel\CurrencyCollection */
    private $entities;

    /**
     * @param null|ReadModel\CurrencyCollection $entities
     */
    public function __construct(ReadModel\CurrencyCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\CurrencyCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onNewCurrencyCreated(Event\NewCurrencyCreated $event): void
    {
        $this->entities->add(
            ReadModel\Currency::fromCode($event->aggregateId())
                ->setSymbol($event->currencySymbol())
                ->setPriceFormat($event->currencyPriceFormat())
                ->setPriceDecimalSeparator($event->currencyPriceDecimalSeparator())
                ->setPriceThousandSeparator($event->currencyPriceThousandSeparator())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCurrencyUpdated(Event\ExistingCurrencyUpdated $event): void
    {
        $this->entities->add(
            ReadModel\Currency::fromCode($event->aggregateId())
                ->setSymbol($event->currencySymbol())
                ->setPriceFormat($event->currencyPriceFormat())
                ->setPriceDecimalSeparator($event->currencyPriceDecimalSeparator())
                ->setPriceThousandSeparator($event->currencyPriceThousandSeparator())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCurrencyRefreshed(Event\ExistingCurrencyRefreshed $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setRate($event->currencyRate())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCurrencyTranslated(Event\ExistingCurrencyTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $site = $this->entities->get($event->aggregateId())
            ->setNames($event->currencyNames())
        ;

        $this->entities->add($site);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function onExistingCurrencyRemoved(Event\ExistingCurrencyRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $code
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Currency
     */
    public function get(string $code): ReadModel\Currency
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
                'Currency does not exists on given identity: %s',
                $code
            ));
        }
    }
}

<?php

namespace N3ttech\Intl\Infrastructure\Persist\Currency;

use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class CurrencyRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Currency::class;
    }

    /**
     * @param Currency $currency
     *
     * @throws \Exception
     */
    public function save(Currency $currency): void
    {
        $this->saveAggregateRoot($currency);
    }

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Currency
     */
    public function find(string $code): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Intl\Currency\Code::fromCode($code));
    }
}

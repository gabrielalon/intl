<?php

namespace N3ttech\Intl\Infrastructure\Persist\Country;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class CountryRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Country::class;
    }

    /**
     * @param Country $country
     *
     * @throws \Exception
     */
    public function save(Country $country): void
    {
        $this->saveAggregateRoot($country);
    }

    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Country
     */
    public function find(string $code): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Intl\Country\Code::fromCode($code));
    }
}

<?php

namespace N3ttech\Intl\Test\Application\Currency\Query;

use N3ttech\Intl\Application\Currency\Query;
use N3ttech\Intl\Application\Currency\Service;
use N3ttech\Intl\Infrastructure\Query\Currency\InMemoryCurrencyQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Currency */
    private $currency;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->currency = Query\ReadModel\Currency::fromCode('PLN');

        $collection = new Query\ReadModel\CurrencyCollection();
        $collection->add($this->currency);

        $currencyQuery = new InMemoryCurrencyQuery($collection);
        $this->register(Query\V1\FindOneByCodeHandler::class, new Query\V1\FindOneByCodeHandler($currencyQuery));
    }

    /**
     * @test
     */
    public function isFindsCurrencyByCode()
    {
        $manager = new Service\CurrencyQueryManager($this->getQueryBus());

        $currency = $manager->findOneByCode($this->currency->identifier());

        $this->assertTrue($currency->getCode()->equals($this->currency->getCode()));
    }
}

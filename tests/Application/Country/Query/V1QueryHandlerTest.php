<?php

namespace N3ttech\Intl\Test\Application\Country\Query;

use N3ttech\Intl\Application\Country\Query;
use N3ttech\Intl\Application\Country\Service;
use N3ttech\Intl\Infrastructure\Query\Country\InMemoryCountryQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Country */
    private $currency;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->currency = Query\ReadModel\Country::fromCode('pl')
            ->setActive(VO\Option\Check::fromBoolean(true))
        ;

        $collection = new Query\ReadModel\CountryCollection();
        $collection->add($this->currency);

        $currencyQuery = new InMemoryCountryQuery($collection);
        $this->register(Query\V1\FindOneByCodeHandler::class, new Query\V1\FindOneByCodeHandler($currencyQuery));
        $this->register(Query\V1\FindAllActiveHandler::class, new Query\V1\FindAllActiveHandler($currencyQuery));
    }

    /**
     * @test
     */
    public function isFindsCountryByCode()
    {
        $manager = new Service\CountryQueryManager($this->getQueryBus());

        $currency = $manager->findOneByCode($this->currency->identifier());

        $this->assertTrue($currency->getCode()->equals($this->currency->getCode()));
    }

    /**
     * @test
     */
    public function isFindsAllActiveCountries()
    {
        $manager = new Service\CountryQueryManager($this->getQueryBus());

        $collection = $manager->findAllActive();

        $this->assertEquals(1, $collection->count());
    }
}

<?php

namespace N3ttech\Intl\Test\Application\Continent\Query;

use N3ttech\Intl\Application\Continent\Query;
use N3ttech\Intl\Application\Continent\Service;
use N3ttech\Intl\Infrastructure\Query\Continent\InMemoryContinentQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Continent */
    private $continent;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->continent = Query\ReadModel\Continent::fromCode('eu')
            ->setNames(VO\Intl\Locales::fromArray(['pl' => 'Europa', 'en' => 'Europe']))
        ;

        $collection = new Query\ReadModel\ContinentCollection();
        $collection->add($this->continent);

        $continentQuery = new InMemoryContinentQuery($collection);
        $this->register(Query\V1\FindOneByCodeHandler::class, new Query\V1\FindOneByCodeHandler($continentQuery));
    }

    /**
     * @test
     */
    public function isFindsContinentByCode()
    {
        $manager = new Service\ContinentQueryManager($this->getQueryBus());

        $continent = $manager->findOneByCode($this->continent->identifier());

        $this->assertTrue($continent->getCode()->equals($this->continent->getCode()));
    }
}

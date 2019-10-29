<?php

namespace N3ttech\Intl\Test\Application\VatRate\Query;

use N3ttech\Intl\Application\VatRate\Query;
use N3ttech\Intl\Application\VatRate\Service;
use N3ttech\Intl\Infrastructure\Query\VatRate\InMemoryVatRateQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\VatRate */
    private $vatRate;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->vatRate = Query\ReadModel\VatRate::fromIdentity(Uuid::uuid4()->toString());

        $collection = new Query\ReadModel\VatRateCollection();
        $collection->add($this->vatRate);

        $vatRateQuery = new InMemoryVatRateQuery($collection);
        $this->register(Query\V1\FindOneByIdentityHandler::class, new Query\V1\FindOneByIdentityHandler($vatRateQuery));
    }

    /**
     * @test
     */
    public function isFindsVatRateByIdentity()
    {
        $manager = new Service\VatRateQueryManager($this->getQueryBus());

        $vatRate = $manager->findOneByIdentity($this->vatRate->identifier());

        $this->assertTrue($vatRate->getUuid()->equals($this->vatRate->getUuid()));
    }
}

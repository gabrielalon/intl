<?php

namespace N3ttech\Intl\Test\Application\Site\Query;

use N3ttech\Intl\Application\Site\Query;
use N3ttech\Intl\Application\Site\Service;
use N3ttech\Intl\Infrastructure\Query\Site\InMemorySiteQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Site */
    private $site;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->site = Query\ReadModel\Site::fromIdentity(Uuid::uuid4()->toString())
            ->setHost(VO\Char\Text::fromString('test.host'))
        ;

        $collection = new Query\ReadModel\SiteCollection();
        $collection->add($this->site);

        $siteQuery = new InMemorySiteQuery($collection);
        $this->register(Query\V1\FindOneByIdentityHandler::class, new Query\V1\FindOneByIdentityHandler($siteQuery));
        $this->register(Query\V1\FindOneByHostHandler::class, new Query\V1\FindOneByHostHandler($siteQuery));
    }

    /**
     * @test
     */
    public function isFindsSiteByHost()
    {
        $manager = new Service\SiteQueryManager($this->getQueryBus());

        $site = $manager->findOneByHost($this->site->host());

        $this->assertTrue($site->getUuid()->equals($this->site->getUuid()));
    }

    /**
     * @test
     */
    public function isFindsSiteByIdentity()
    {
        $manager = new Service\SiteQueryManager($this->getQueryBus());

        $site = $manager->findOneByIdentity($this->site->identifier());

        $this->assertTrue($site->getUuid()->equals($this->site->getUuid()));
    }
}

<?php

namespace N3ttech\Intl\Test\Application\Site\Command;

use N3ttech\Intl\Application\Site\Command;
use N3ttech\Intl\Application\Site\Event;
use N3ttech\Intl\Domain\Model\Site\Projection;
use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Intl\Infrastructure\Persist\Site\SiteRepository;
use N3ttech\Intl\Infrastructure\Projection\Site\InMemorySiteProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class RemoveSiteHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new SiteRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\SiteProjection::class, new InMemorySiteProjector());
        $this->register(Command\CreateSiteHandler::class, new Command\CreateSiteHandler($repository));
        $this->register(Command\RemoveSiteHandler::class, new Command\RemoveSiteHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRemovesExistingSiteTest()
    {
        //given
        $command = new Command\CreateSite(Uuid::uuid4()->toString(), 'test.host');
        $this->getCommandBus()->dispatch($command);

        $command = new Command\RemoveSite($command->getUuid());

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemorySiteProjector $projector */
        $projector = $this->container->get(Projection\SiteProjection::class);
        $this->expectException(\RuntimeException::class);
        $projector->get($command->getUuid());

        $aggregateId = VO\Identity\Uuid::fromIdentity($command->getUuid());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingSiteRemoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertEquals($command->getUuid(), $event->siteUuid()->toString());
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Site::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

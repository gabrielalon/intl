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
class FlagSiteHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new SiteRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\SiteProjection::class, new InMemorySiteProjector());
        $this->register(Command\CreateSiteHandler::class, new Command\CreateSiteHandler($repository));
        $this->register(Command\FlagSiteHandler::class, new Command\FlagSiteHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itFlaggesExistingSiteTest()
    {
        //given
        $command = new Command\CreateSite(Uuid::uuid4()->toString(), 'test.host');
        $this->getCommandBus()->dispatch($command);

        $command = new Command\FlagSite($command->getUuid(), true, true);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemorySiteProjector $projector */
        $projector = $this->container->get(Projection\SiteProjection::class);
        $entity = $projector->get($command->getUuid());

        $this->assertEquals($entity->identifier(), $command->getUuid());
        $this->assertEquals($entity->isAuth(), $command->isAuth());
        $this->assertEquals($entity->isMobile(), $command->isMobile());

        $aggregateId = VO\Identity\Uuid::fromIdentity($command->getUuid());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingSiteFlagged $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->siteUuid()));
            $this->assertTrue($entity->getMobile()->equals($event->siteMobile()));
            $this->assertTrue($entity->getAuth()->equals($event->siteAuth()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Site::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

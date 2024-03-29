<?php

namespace N3ttech\Intl\Test\Application\Continent\Command;

use N3ttech\Intl\Application\Continent\Command;
use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Intl\Domain\Model\Continent\Projection;
use N3ttech\Intl\Infrastructure\Persist\Continent\ContinentRepository;
use N3ttech\Intl\Infrastructure\Projection\Continent\InMemoryContinentProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class CreateContinentHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new ContinentRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\ContinentProjection::class, new InMemoryContinentProjector());
        $this->register(Command\CreateContinentHandler::class, new Command\CreateContinentHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCreatesNewContinentTest()
    {
        //given
        $command = new Command\CreateContinent('eu', ['pl' => 'Europa', 'en' => 'Europe']);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryContinentProjector $projector */
        $projector = $this->container->get(Projection\ContinentProjection::class);
        $entity = $projector->get($command->getCode());

        $this->assertEquals($entity->identifier(), $command->getCode());
        $this->assertEquals($entity->names(), $command->getNames());

        $aggregateId = VO\Intl\Continent\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 1);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\NewContinentCreated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getCode()->equals($event->continentCode()));
            $this->assertTrue($entity->getNames()->equals($event->continentNames()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Continent::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 1);
    }
}

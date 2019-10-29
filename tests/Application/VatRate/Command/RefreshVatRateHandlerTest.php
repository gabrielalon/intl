<?php

namespace N3ttech\Intl\Test\Application\VatRate\Command;

use N3ttech\Intl\Application\VatRate\Command;
use N3ttech\Intl\Application\VatRate\Event;
use N3ttech\Intl\Domain\Model\VatRate\Projection;
use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Intl\Infrastructure\Persist\VatRate\VatRateRepository;
use N3ttech\Intl\Infrastructure\Projection\VatRate\InMemoryVatRateProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class RefreshVatRateHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new VatRateRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\VatRateProjection::class, new InMemoryVatRateProjector());
        $this->register(Command\CreateVatRateHandler::class, new Command\CreateVatRateHandler($repository));
        $this->register(Command\RefreshVatRateHandler::class, new Command\RefreshVatRateHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRefreshesExistingVatRateTest()
    {
        //given
        $command = new Command\CreateVatRate(Uuid::uuid4()->toString(), 0.23);
        $this->getCommandBus()->dispatch($command);

        $command = new Command\RefreshVatRate($command->getUuid(), 0.05);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryVatRateProjector $projector */
        $projector = $this->container->get(Projection\VatRateProjection::class);
        $entity = $projector->get($command->getUuid());

        $this->assertEquals($entity->identifier(), $command->getUuid());
        $this->assertEquals($entity->rate(), $command->getRate());

        $aggregateId = VO\Identity\Uuid::fromIdentity($command->getUuid());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingVatRateRefreshed $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->vatRateUuid()));
            $this->assertTrue($entity->getRate()->equals($event->vatRateRate()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(VatRate::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

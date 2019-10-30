<?php

namespace N3ttech\Intl\Test\Application\Country\Command;

use N3ttech\Intl\Application\Country\Command;
use N3ttech\Intl\Application\Country\Event;
use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Intl\Domain\Model\Country\Projection;
use N3ttech\Intl\Infrastructure\Persist\Country\CountryRepository;
use N3ttech\Intl\Infrastructure\Projection\Country\InMemoryCountryProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class UpdateCountryHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new CountryRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\CountryProjection::class, new InMemoryCountryProjector());
        $this->register(Command\CreateCountryHandler::class, new Command\CreateCountryHandler($repository));
        $this->register(Command\UpdateCountryHandler::class, new Command\UpdateCountryHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCreatesNewCountryTest()
    {
        //given
        $command = new Command\CreateCountry('PL', 'eu', Uuid::uuid4()->toString());
        $this->getCommandBus()->dispatch($command);

        $command = new Command\UpdateCountry($command->getCode(), 'oc', Uuid::uuid4()->toString());

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryCountryProjector $projector */
        $projector = $this->container->get(Projection\CountryProjection::class);
        $entity = $projector->get($command->getCode());

        $this->assertEquals($entity->identifier(), $command->getCode());
        $this->assertEquals($entity->continent(), $command->getContinent());
        $this->assertEquals($entity->vatRate(), $command->getVatRate());
        $this->assertEquals($entity->dateFormat(), $command->getDateFormat());
        $this->assertEquals($entity->timeFormat(), $command->getTimeFormat());

        $aggregateId = VO\Intl\Country\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingCountryUpdated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getCode()->equals($event->countryCode()));
            $this->assertTrue($entity->getContinent()->equals($event->countryContinent()));
            $this->assertTrue($entity->getVatRate()->equals($event->countryVatRate()));
            $this->assertTrue($entity->getDateFormat()->equals($event->countryDateFormat()));
            $this->assertTrue($entity->getTimeFormat()->equals($event->countryTimeFormat()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Country::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

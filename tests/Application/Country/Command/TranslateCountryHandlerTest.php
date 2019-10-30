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
class TranslateCountryHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new CountryRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\CountryProjection::class, new InMemoryCountryProjector());
        $this->register(Command\CreateCountryHandler::class, new Command\CreateCountryHandler($repository));
        $this->register(Command\TranslateCountryHandler::class, new Command\TranslateCountryHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingCountryTest()
    {
        //given
        $command = new Command\CreateCountry('PL', 'eu', Uuid::uuid4()->toString());
        $this->getCommandBus()->dispatch($command);

        $command = new Command\TranslateCountry($command->getCode(), ['pl' => 'test']);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryCountryProjector $projector */
        $projector = $this->container->get(Projection\CountryProjection::class);
        $entity = $projector->get($command->getCode());

        $this->assertEquals($entity->identifier(), $command->getCode());
        $this->assertEquals($entity->names(), $command->getNames());

        $aggregateId = VO\Intl\Country\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingCountryTranslated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getCode()->equals($event->countryCode()));
            $this->assertTrue($entity->getNames()->equals($event->countryNames()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Country::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

<?php

namespace N3ttech\Intl\Test\Application\Language\Command;

use N3ttech\Intl\Application\Language\Command;
use N3ttech\Intl\Application\Language\Event;
use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Intl\Domain\Model\Language\Projection;
use N3ttech\Intl\Infrastructure\Persist\Language\LanguageRepository;
use N3ttech\Intl\Infrastructure\Projection\Language\InMemoryLanguageProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class CreateLanguageHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new LanguageRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\LanguageProjection::class, new InMemoryLanguageProjector());
        $this->register(Command\CreateLanguageHandler::class, new Command\CreateLanguageHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCreatesNewLanguageTest()
    {
        //given
        $command = new Command\CreateLanguage('eu', ['pl' => 'Polski', 'en' => 'Polish']);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryLanguageProjector $projector */
        $projector = $this->container->get(Projection\LanguageProjection::class);
        $entity = $projector->get($command->getLocale());

        $this->assertEquals($entity->identifier(), $command->getLocale());
        $this->assertEquals($entity->names(), $command->getNames());

        $aggregateId = VO\Intl\Language\Locale::fromLocale($command->getLocale());
        $collection = $this->getStreamRepository()->load($aggregateId, 1);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\NewLanguageCreated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getLocale()->equals($event->languageLocale()));
            $this->assertTrue($entity->getNames()->equals($event->languageNames()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Language::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 1);
    }
}

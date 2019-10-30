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
class RemoveLanguageHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new LanguageRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\LanguageProjection::class, new InMemoryLanguageProjector());
        $this->register(Command\CreateLanguageHandler::class, new Command\CreateLanguageHandler($repository));
        $this->register(Command\RemoveLanguageHandler::class, new Command\RemoveLanguageHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRemovesExistingLanguageTest()
    {
        //given
        $command = new Command\CreateLanguage('eu', ['pl' => 'Polski', 'en' => 'Polish']);
        $this->getCommandBus()->dispatch($command);

        $command = new Command\RemoveLanguage($command->getCode());

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryLanguageProjector $projector */
        $projector = $this->container->get(Projection\LanguageProjection::class);
        $this->expectException(\RuntimeException::class);
        $projector->get($command->getCode());

        $aggregateId = VO\Intl\Language\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingLanguageRemoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertEquals($command->getCode(), $event->languageLocale()->toString());
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Language::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

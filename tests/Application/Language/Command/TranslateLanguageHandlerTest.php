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
class TranslateLanguageHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new LanguageRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\LanguageProjection::class, new InMemoryLanguageProjector());
        $this->register(Command\CreateLanguageHandler::class, new Command\CreateLanguageHandler($repository));
        $this->register(Command\TranslateLanguageHandler::class, new Command\TranslateLanguageHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itFlaggesExistingLanguageTest()
    {
        //given
        $command = new Command\CreateLanguage('eu', ['pl' => 'Polski', 'en' => 'Polish']);
        $this->getCommandBus()->dispatch($command);

        $command = new Command\TranslateLanguage($command->getCode(), ['pl' => 'Test', 'en' => 'Test']);

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryLanguageProjector $projector */
        $projector = $this->container->get(Projection\LanguageProjection::class);
        $entity = $projector->get($command->getCode());

        $this->assertEquals($entity->identifier(), $command->getCode());
        $this->assertEquals($entity->names(), $command->getNames());

        $aggregateId = VO\Intl\Language\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingLanguageTranslated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getLocale()->equals($event->languageLocale()));
            $this->assertTrue($entity->getNames()->equals($event->languageNames()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Language::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

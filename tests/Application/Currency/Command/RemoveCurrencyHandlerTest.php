<?php

namespace N3ttech\Intl\Test\Application\Currency\Command;

use N3ttech\Intl\Application\Currency\Command;
use N3ttech\Intl\Application\Currency\Event;
use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Intl\Domain\Model\Currency\Projection;
use N3ttech\Intl\Infrastructure\Persist\Currency\CurrencyRepository;
use N3ttech\Intl\Infrastructure\Projection\Currency\InMemoryCurrencyProjector;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class RemoveCurrencyHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new CurrencyRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\CurrencyProjection::class, new InMemoryCurrencyProjector());
        $this->register(Command\CreateCurrencyHandler::class, new Command\CreateCurrencyHandler($repository));
        $this->register(Command\RemoveCurrencyHandler::class, new Command\RemoveCurrencyHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itRemovesExistingCurrencyTest()
    {
        //given
        $command = new Command\CreateCurrency('PLN', 'zł', '%s %e');
        $this->getCommandBus()->dispatch($command);

        $command = new Command\RemoveCurrency($command->getCode());

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryCurrencyProjector $projector */
        $projector = $this->container->get(Projection\CurrencyProjection::class);
        $this->expectException(\RuntimeException::class);
        $projector->get($command->getCode());

        $aggregateId = VO\Intl\Currency\Code::fromCode($command->getCode());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingCurrencyRemoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertEquals($command->getCode(), $event->currencyCode()->toString());
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Currency::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}

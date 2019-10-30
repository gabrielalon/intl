<?php

namespace N3ttech\Intl\Test\Application\Continent;

use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class ContinentTest extends AggregateChangedTestCase
{
    /** @var VO\Intl\Continent\Code */
    private $code;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->code = VO\Intl\Continent\Code::fromCode('eu');
        $this->names = VO\Intl\Language\Texts::fromArray(['pl' => 'Europa', 'en' => 'Europe']);
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewContinentTest()
    {
        $continent = Continent::createNewContinent($this->code, $this->names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($continent);

        $this->assertCount(1, $events);

        /** @var Event\NewContinentCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewContinentCreated::class, $event->messageName());
        $this->assertTrue($this->code->equals($event->continentCode()));
        $this->assertTrue($this->names->equals($event->continentNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itUpdatesExistingContinentTest()
    {
        /** @var Continent $continent */
        $continent = $this->reconstituteReturnPackageFromHistory($this->newContinentCreated());

        $names = VO\Intl\Language\Texts::fromArray(['pl' => 'Test', 'en' => 'Test']);

        $continent->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($continent);

        $this->assertCount(1, $events);

        /** @var Event\ExistingContinentTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingContinentTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->continentNames()));
    }

    /**
     * @test
     */
    public function itRemovesExistingContinentTest()
    {
        /** @var Continent $continent */
        $continent = $this->reconstituteReturnPackageFromHistory($this->newContinentCreated());
        $continent->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($continent);

        $this->assertCount(1, $events);

        /** @var Event\ExistingContinentRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingContinentRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Continent::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newContinentCreated(): AggregateChanged
    {
        return Event\NewContinentCreated::occur($this->code->toString(), [
            'names' => $this->names->raw(),
        ]);
    }
}

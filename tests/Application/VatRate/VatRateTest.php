<?php

namespace N3ttech\Intl\Test\Application\VatRate;

use N3ttech\Intl\Application\VatRate\Event;
use N3ttech\Intl\Domain\Model\VatRate\VatRate;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class VatRateTest extends AggregateChangedTestCase
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Number\Decimal */
    private $rate;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->uuid = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
        $this->rate = VO\Number\Decimal::fromFloat(0.23);
        $this->names = VO\Intl\Language\Locales::fromArray(['pl' => '23']);
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewVatRateTest()
    {
        $vatRate = VatRate::createNewVatRate(
            $this->uuid,
            $this->rate,
            $this->names
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($vatRate);

        $this->assertCount(1, $events);

        /** @var Event\NewVatRateCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewVatRateCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->vatRateUuid()));
        $this->assertTrue($this->rate->equals($event->vatRateRate()));
        $this->assertTrue($this->names->equals($event->vatRateNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingVatRateTest()
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->reconstituteReturnPackageFromHistory($this->newVatRateCreated());

        $names = VO\Intl\Language\Locales::fromArray(['pl' => '5']);

        $vatRate->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($vatRate);

        $this->assertCount(1, $events);

        /** @var Event\ExistingVatRateTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingVatRateTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->vatRateNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itRefreshesExistingVatRateTest()
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->reconstituteReturnPackageFromHistory($this->newVatRateCreated());

        $rate = VO\Number\Decimal::fromFloat(0.05);

        $vatRate->refresh($rate);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($vatRate);

        $this->assertCount(1, $events);

        /** @var Event\ExistingVatRateRefreshed $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingVatRateRefreshed::class, $event->messageName());
        $this->assertTrue($rate->equals($event->vatRateRate()));
    }

    /**
     * @test
     */
    public function itRemovesExistingVatRateTest()
    {
        /** @var VatRate $vatRate */
        $vatRate = $this->reconstituteReturnPackageFromHistory($this->newVatRateCreated());
        $vatRate->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($vatRate);

        $this->assertCount(1, $events);

        /** @var Event\ExistingVatRateRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingVatRateRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            VatRate::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newVatRateCreated(): AggregateChanged
    {
        return Event\NewVatRateCreated::occur($this->uuid->toString(), [
            'rate' => $this->rate->raw(),
            'names' => $this->names->raw(),
        ]);
    }
}

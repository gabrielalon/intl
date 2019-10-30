<?php

namespace N3ttech\Intl\Test\Application\Country;

use N3ttech\Intl\Application\Country\Event;
use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class CountryTest extends AggregateChangedTestCase
{
    /** @var VO\Intl\Country\Code */
    private $code;

    /** @var VO\Intl\Continent\Code */
    private $continent;

    /** @var VO\Char\Text */
    private $dateFormat;

    /** @var VO\Char\Text */
    private $timeFormat;

    /** @var VO\Identity\Uuid */
    private $vatRate;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->code = VO\Intl\Country\Code::fromCode('PL');
        $this->continent = VO\Intl\Continent\Code::fromCode('eu');
        $this->dateFormat = VO\Char\Text::fromString('Y-m-d');
        $this->timeFormat = VO\Char\Text::fromString('H:i:s');
        $this->vatRate = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewCountryTest()
    {
        $country = Country::createNewCountry(
            $this->code,
            $this->continent,
            $this->vatRate,
            $this->dateFormat,
            $this->timeFormat
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\NewCountryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewCountryCreated::class, $event->messageName());
        $this->assertTrue($this->code->equals($event->countryCode()));
        $this->assertTrue($this->continent->equals($event->countryContinent()));
        $this->assertTrue($this->vatRate->equals($event->countryVatRate()));
        $this->assertTrue($this->dateFormat->equals($event->countryDateFormat()));
        $this->assertTrue($this->timeFormat->equals($event->countryTimeFormat()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itUpdatesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $continent = VO\Intl\Continent\Code::fromCode('oc');
        $vatRate = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
        $dateFormat = VO\Char\Text::fromString('Y-m-d');
        $timeFormat = VO\Char\Text::fromString('H:i:s');

        $country->update($continent, $vatRate, $dateFormat, $timeFormat);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryUpdated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryUpdated::class, $event->messageName());
        $this->assertTrue($continent->equals($event->countryContinent()));
        $this->assertTrue($vatRate->equals($event->countryVatRate()));
        $this->assertTrue($dateFormat->equals($event->countryDateFormat()));
        $this->assertTrue($timeFormat->equals($event->countryTimeFormat()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $names = VO\Intl\Language\Texts::fromArray(['pl' => 'Xxx']);

        $country->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->countryNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itActivatesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $country->activate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryActivated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryActivated::class, $event->messageName());
        $this->assertTrue($event->countryActive()->raw());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itDectivatesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $country->deactivate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryDeactivated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryDeactivated::class, $event->messageName());
        $this->assertFalse($event->countryActive()->raw());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itRegionizesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $regions = VO\Intl\Country\Regions::fromArray([['pl' => 'Opolskie']]);

        $country->regionize($regions);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryRegionized $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryRegionized::class, $event->messageName());

        $this->assertTrue($regions->equals($event->countryRegions()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itInternationalizesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());

        $currencies = VO\Intl\Currency\Codes::fromArray(['EUR']);
        $languages = VO\Intl\Language\Codes::fromArray(['pl']);

        $country->internationalize($currencies, $languages);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryInternationalized $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryInternationalized::class, $event->messageName());
        $this->assertTrue($currencies->equals($event->countryCurrencies()));
        $this->assertTrue($languages->equals($event->countryLanguages()));
    }

    /**
     * @test
     */
    public function itRemovesExistingCountryTest()
    {
        /** @var Country $country */
        $country = $this->reconstituteReturnPackageFromHistory($this->newCountryCreated());
        $country->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($country);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCountryRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCountryRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Country::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newCountryCreated(): AggregateChanged
    {
        return Event\NewCountryCreated::occur($this->code->toString(), [
            'continent' => $this->continent->toString(),
            'vat_rate' => $this->vatRate->toString(),
            'date_format' => $this->dateFormat->toString(),
            'time_format' => $this->timeFormat->toString(),
        ]);
    }
}

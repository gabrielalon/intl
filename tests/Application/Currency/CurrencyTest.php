<?php

namespace N3ttech\Intl\Test\Application\Currency;

use N3ttech\Intl\Application\Currency\Event;
use N3ttech\Intl\Domain\Model\Currency\Currency;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class CurrencyTest extends AggregateChangedTestCase
{
    /** @var VO\Intl\Currency\Code */
    private $code;

    /** @var VO\Char\Text */
    private $symbol;

    /** @var VO\Char\Text */
    private $priceFormat;

    /** @var VO\Char\Text */
    private $priceDecimalSeparator;

    /** @var VO\Char\Text */
    private $priceThousandSeparator;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->code = VO\Intl\Currency\Code::fromCode('PLN');
        $this->symbol = VO\Char\Text::fromString('zł');
        $this->priceFormat = VO\Char\Text::fromString('%s %e');
        $this->priceDecimalSeparator = VO\Char\Text::fromString(',');
        $this->priceThousandSeparator = VO\Char\Text::fromString('.');
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewCurrencyTest()
    {
        $currency = Currency::createNewCurrency(
            $this->code,
            $this->symbol,
            $this->priceFormat,
            $this->priceDecimalSeparator,
            $this->priceThousandSeparator
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($currency);

        $this->assertCount(1, $events);

        /** @var Event\NewCurrencyCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewCurrencyCreated::class, $event->messageName());
        $this->assertTrue($this->code->equals($event->currencyCode()));
        $this->assertTrue($this->symbol->equals($event->currencySymbol()));
        $this->assertTrue($this->priceFormat->equals($event->currencyPriceFormat()));
        $this->assertTrue($this->priceDecimalSeparator->equals($event->currencyPriceDecimalSeparator()));
        $this->assertTrue($this->priceThousandSeparator->equals($event->currencyPriceThousandSeparator()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itUpdatesExistingCurrencyTest()
    {
        /** @var Currency $currency */
        $currency = $this->reconstituteReturnPackageFromHistory($this->newCurrencyCreated());

        $symbol = VO\Char\Text::fromString('zl');
        $priceFormat = VO\Char\Text::fromString('%e %s');
        $priceDecimalSeparator = VO\Char\Text::fromString('.');
        $priceThousandSeparator = VO\Char\Text::fromString(',');

        $currency->update($symbol, $priceFormat, $priceDecimalSeparator, $priceThousandSeparator);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($currency);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCurrencyUpdated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCurrencyUpdated::class, $event->messageName());
        $this->assertTrue($symbol->equals($event->currencySymbol()));
        $this->assertTrue($priceFormat->equals($event->currencyPriceFormat()));
        $this->assertTrue($priceDecimalSeparator->equals($event->currencyPriceDecimalSeparator()));
        $this->assertTrue($priceThousandSeparator->equals($event->currencyPriceThousandSeparator()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingCurrencyTest()
    {
        /** @var Currency $currency */
        $currency = $this->reconstituteReturnPackageFromHistory($this->newCurrencyCreated());

        $names = VO\Intl\Language\Locales::fromArray(['pl' => 'Złoty']);

        $currency->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($currency);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCurrencyTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCurrencyTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->currencyNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itRefreshesExistingCurrencyTest()
    {
        /** @var Currency $currency */
        $currency = $this->reconstituteReturnPackageFromHistory($this->newCurrencyCreated());

        $rate = VO\Number\Decimal::fromFloat(4.25);

        $currency->refresh($rate);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($currency);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCurrencyRefreshed $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCurrencyRefreshed::class, $event->messageName());
        $this->assertTrue($rate->equals($event->currencyRate()));
    }

    /**
     * @test
     */
    public function itRemovesExistingCurrencyTest()
    {
        /** @var Currency $currency */
        $currency = $this->reconstituteReturnPackageFromHistory($this->newCurrencyCreated());
        $currency->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($currency);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCurrencyRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCurrencyRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Currency::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newCurrencyCreated(): AggregateChanged
    {
        return Event\NewCurrencyCreated::occur($this->code->toString(), [
            'symbol' => $this->symbol->toString(),
            'price_format' => $this->priceFormat->toString(),
            'price_decimal_separator' => $this->priceDecimalSeparator->toString(),
            'price_thousand_separator' => $this->priceThousandSeparator->toString(),
        ]);
    }
}

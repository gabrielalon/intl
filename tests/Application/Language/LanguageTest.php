<?php

namespace N3ttech\Intl\Test\Application\Language;

use N3ttech\Intl\Application\Language\Event;
use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class LanguageTest extends AggregateChangedTestCase
{
    /** @var VO\Intl\Language\Locale */
    private $locale;

    /** @var VO\Intl\Language\Locales */
    private $names;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->locale = VO\Intl\Language\Locale::fromLocale('eu');
        $this->names = VO\Intl\Language\Locales::fromArray(['pl' => 'Polski', 'en' => 'Polish']);
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewLanguageTest()
    {
        $language = Language::createNewLanguage($this->locale, $this->names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($language);

        $this->assertCount(1, $events);

        /** @var Event\NewLanguageCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewLanguageCreated::class, $event->messageName());
        $this->assertTrue($this->locale->equals($event->languageLocale()));
        $this->assertTrue($this->names->equals($event->languageNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itUpdatesExistingLanguageTest()
    {
        /** @var Language $language */
        $language = $this->reconstituteReturnPackageFromHistory($this->newLanguageCreated());

        $names = VO\Intl\Language\Locales::fromArray(['pl' => 'Test', 'en' => 'Test']);

        $language->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($language);

        $this->assertCount(1, $events);

        /** @var Event\ExistingLanguageTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingLanguageTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->languageNames()));
    }

    /**
     * @test
     */
    public function itRemovesExistingLanguageTest()
    {
        /** @var Language $language */
        $language = $this->reconstituteReturnPackageFromHistory($this->newLanguageCreated());
        $language->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($language);

        $this->assertCount(1, $events);

        /** @var Event\ExistingLanguageRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingLanguageRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Language::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newLanguageCreated(): AggregateChanged
    {
        return Event\NewLanguageCreated::occur($this->locale->toString(), [
            'names' => $this->names->raw(),
        ]);
    }
}

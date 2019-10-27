<?php

namespace N3ttech\Intl\Test\Application\Site;

use N3ttech\Intl\Application\Site\Event;
use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Intl\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class SiteTest extends AggregateChangedTestCase
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Char\Text */
    private $host;

    /** @var VO\Option\Check */
    private $mobile;

    /** @var VO\Option\Check */
    private $auth;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->uuid = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
        $this->host = VO\Char\Text::fromString('test.host');
        $this->mobile = VO\Option\Check::fromBoolean(true);
        $this->auth = VO\Option\Check::fromBoolean(false);
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewSiteTest()
    {
        $site = Site::createNewSite(
            $this->uuid,
            $this->host,
            $this->mobile,
            $this->auth
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($site);

        $this->assertCount(1, $events);

        /** @var Event\NewSiteCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewSiteCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->siteUuid()));
        $this->assertTrue($this->host->equals($event->siteHost()));
        $this->assertTrue($this->mobile->equals($event->siteMobile()));
        $this->assertTrue($this->auth->equals($event->siteAuth()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCategorizesExistingSiteTest()
    {
        /** @var Site $site */
        $site = $this->reconstituteReturnPackageFromHistory($this->newSiteCreated());

        $categories = VO\Identity\Uuids::fromArray([
            VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString()),
            VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString()),
        ]);

        $site->categorized($categories);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($site);

        $this->assertCount(1, $events);

        /** @var Event\ExistingSiteCategorized $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingSiteCategorized::class, $event->messageName());
        $this->assertTrue($categories->equals($event->siteCategories()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itFlagsExistingSiteTest()
    {
        /** @var Site $site */
        $site = $this->reconstituteReturnPackageFromHistory($this->newSiteCreated());

        $mobile = VO\Option\Check::fromBoolean(false);
        $auth = VO\Option\Check::fromBoolean(true);

        $site->flagged($mobile, $auth);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($site);

        $this->assertCount(1, $events);

        /** @var Event\ExistingSiteFlagged $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingSiteFlagged::class, $event->messageName());
        $this->assertTrue($mobile->equals($event->siteMobile()));
        $this->assertTrue($auth->equals($event->siteAuth()));
    }

    /**
     * @test
     */
    public function itRemovesExistingSiteTest()
    {
        /** @var Site $site */
        $site = $this->reconstituteReturnPackageFromHistory($this->newSiteCreated());
        $site->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($site);

        $this->assertCount(1, $events);

        /** @var Event\ExistingSiteRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingSiteRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Site::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newSiteCreated(): AggregateChanged
    {
        return Event\NewSiteCreated::occur($this->uuid->toString(), [
            'host' => $this->host->toString(),
            'mobile' => $this->mobile->raw(),
            'auth' => $this->auth->raw(),
        ]);
    }
}

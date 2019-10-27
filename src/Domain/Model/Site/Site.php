<?php

namespace N3ttech\Intl\Domain\Model\Site;

use N3ttech\Intl\Application\Site\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Site extends AggregateRoot
{
    /** @var VO\Char\Text */
    private $host;

    /** @var VO\Identity\Uuids */
    private $categories;

    /** @var VO\Option\Check */
    private $mobile;

    /** @var VO\Option\Check */
    private $auth;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Site
     */
    public function setUuid(VO\Identity\Uuid $uuid): Site
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $categories
     *
     * @return Site
     */
    public function setCategories(VO\Identity\Uuids $categories): Site
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param VO\Char\Text $host
     *
     * @return Site
     */
    public function setHost(VO\Char\Text $host): Site
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param VO\Option\Check $mobile
     *
     * @return Site
     */
    public function setMobile(VO\Option\Check $mobile): Site
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @param VO\Option\Check $auth
     *
     * @return Site
     */
    public function setAuth(VO\Option\Check $auth): Site
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     * @param VO\Char\Text     $host
     * @param VO\Option\Check  $mobile
     * @param VO\Option\Check  $auth
     *
     * @return Site
     */
    public static function createNewSite(
        VO\Identity\Uuid $uuid,
        VO\Char\Text $host,
        VO\Option\Check $mobile,
        VO\Option\Check $auth
    ): Site {
        $site = new Site();

        $site->recordThat(Event\NewSiteCreated::occur($uuid->toString(), [
            'host' => $host->toString(),
            'mobile' => $mobile->raw(),
            'auth' => $auth->raw(),
        ]));

        return $site;
    }

    /**
     * @param VO\Option\Check $mobile
     * @param VO\Option\Check $auth
     */
    public function flagged(VO\Option\Check $mobile, VO\Option\Check $auth): void
    {
        $this->recordThat(Event\ExistingSiteFlagged::occur($this->aggregateId(), [
            'mobile' => $mobile->raw(),
            'auth' => $auth->raw(),
        ]));
    }

    /**
     * @param VO\Identity\Uuids $categories
     */
    public function categorized(VO\Identity\Uuids $categories): void
    {
        $this->recordThat(Event\ExistingSiteCategorized::occur($this->aggregateId(), [
            'categories' => $categories->toArray(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingSiteRemoved::occur($this->aggregateId()));
    }
}

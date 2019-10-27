<?php

namespace N3ttech\Intl\Application\Site\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Site implements Viewable
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Char\Text */
    private $host;

    /** @var VO\Identity\Uuids */
    private $categories;

    /** @var VO\Option\Check */
    private $mobile;

    /** @var VO\Option\Check */
    private $auth;

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Site
     */
    public static function fromIdentity(string $uuid): Site
    {
        $site = new static();

        return $site->setUuid(VO\Identity\Uuid::fromIdentity($uuid));
    }

    /**
     * @return string
     */
    public function identifier(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getUuid(): VO\Identity\Uuid
    {
        return $this->uuid;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Site
     */
    public function setUuid(VO\Identity\Uuid $uuid): Site
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function host(): string
    {
        return $this->host->toString();
    }

    /**
     * @return VO\Char\Text
     */
    public function getHost(): VO\Char\Text
    {
        return $this->host;
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
     * @return array
     */
    public function categories(): array
    {
        return $this->categories->toArray();
    }

    /**
     * @return VO\Identity\Uuids
     */
    public function getCategories(): VO\Identity\Uuids
    {
        return $this->categories;
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
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->mobile->raw();
    }

    /**
     * @return VO\Option\Check
     */
    public function getMobile(): VO\Option\Check
    {
        return $this->mobile;
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
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->auth->raw();
    }

    /**
     * @return VO\Option\Check
     */
    public function getAuth(): VO\Option\Check
    {
        return $this->auth;
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
}

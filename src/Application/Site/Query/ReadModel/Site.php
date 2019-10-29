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

    /** @var VO\Intl\Country\Codes */
    private $countries;

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
    public function countries(): array
    {
        return $this->countries->raw();
    }

    /**
     * @return VO\Intl\Country\Codes
     */
    public function getCountries(): VO\Intl\Country\Codes
    {
        return $this->countries;
    }

    /**
     * @param VO\Intl\Country\Codes $countries
     *
     * @return Site
     */
    public function setCountries(VO\Intl\Country\Codes $countries): Site
    {
        $this->countries = $countries;

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

<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Messaging\Command\Command\Command;

class CreateSite extends Command
{
    /** @var string */
    private $uuid;

    /** @var string */
    private $host;

    /** @var bool */
    private $mobile;

    /** @var bool */
    private $auth;

    /**
     * @param string $uuid
     * @param string $host
     * @param bool   $mobile
     * @param bool   $auth
     */
    public function __construct(
        string $uuid,
        string $host,
        bool $mobile = false,
        bool $auth = false
    ) {
        $this->uuid = $uuid;
        $this->host = $host;
        $this->mobile = $mobile;
        $this->auth = $auth;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->mobile;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->auth;
    }
}

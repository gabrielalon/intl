<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Messaging\Command\Command\Command;

class FlagSite extends Command
{
    /** @var string */
    private $uuid;

    /** @var bool */
    private $mobile;

    /** @var bool */
    private $auth;

    /**
     * @param string $uuid
     * @param bool   $mobile
     * @param bool   $auth
     */
    public function __construct(
        string $uuid,
        bool $mobile = false,
        bool $auth = false
    ) {
        $this->uuid = $uuid;
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

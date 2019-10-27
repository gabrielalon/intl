<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Messaging\Command\Command\Command;

class RemoveSite extends Command
{
    /** @var string */
    private $uuid;

    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}

<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Messaging\Command\Command\Command;

class TranslateVatRate extends Command
{
    /** @var string */
    private $uuid;

    /** @var string[] */
    private $names;

    /**
     * @param string   $uuid
     * @param string[] $names
     */
    public function __construct(string $uuid, array $names = [])
    {
        $this->uuid = $uuid;
        $this->names = $names;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}

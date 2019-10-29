<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Messaging\Command\Command\Command;

class CreateVatRate extends Command
{
    /** @var string */
    private $uuid;

    /** @var float */
    private $rate;

    /** @var string[] */
    private $names;

    /**
     * @param string   $uuid
     * @param float    $rate
     * @param string[] $names
     */
    public function __construct(string $uuid, float $rate, array $names = [])
    {
        $this->uuid = $uuid;
        $this->rate = $rate;
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
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}

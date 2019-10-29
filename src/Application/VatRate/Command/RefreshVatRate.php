<?php

namespace N3ttech\Intl\Application\VatRate\Command;

use N3ttech\Messaging\Command\Command\Command;

class RefreshVatRate extends Command
{
    /** @var string */
    private $uuid;

    /** @var float */
    private $rate;

    /**
     * @param string $uuid
     * @param float  $rate
     */
    public function __construct(string $uuid, float $rate)
    {
        $this->uuid = $uuid;
        $this->rate = $rate;
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
}

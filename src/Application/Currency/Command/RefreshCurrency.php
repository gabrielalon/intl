<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Messaging\Command\Command\Command;

class RefreshCurrency extends Command
{
    /** @var string */
    private $code;

    /** @var float */
    private $rate;

    /**
     * @param string $code
     * @param float  $rate
     */
    public function __construct(string $code, float $rate)
    {
        $this->code = $code;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
}

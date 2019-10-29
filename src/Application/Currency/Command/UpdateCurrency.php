<?php

namespace N3ttech\Intl\Application\Currency\Command;

use N3ttech\Messaging\Command\Command\Command;

class UpdateCurrency extends Command
{
    /** @var string */
    private $code;

    /** @var string */
    private $symbol;

    /** @var string */
    private $priceFormat;

    /**
     * @param string $code
     * @param string $symbol
     * @param string $priceFormat
     */
    public function __construct(string $code, string $symbol, string $priceFormat)
    {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->priceFormat = $priceFormat;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getPriceFormat(): string
    {
        return $this->priceFormat;
    }
}

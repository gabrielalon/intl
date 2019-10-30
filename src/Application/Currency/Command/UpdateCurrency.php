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

    /** @var string */
    private $priceDecimalSeparator;

    /** @var string */
    private $priceThousandSeparator;

    /**
     * @param string $code
     * @param string $symbol
     * @param string $priceFormat
     * @param string $priceDecimalSeparator
     * @param string $priceThousandSeparator
     */
    public function __construct(
        string $code,
        string $symbol,
        string $priceFormat = '%p %e',
        string $priceDecimalSeparator = '.',
        string $priceThousandSeparator = ''
    ) {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->priceFormat = $priceFormat;
        $this->priceDecimalSeparator = $priceDecimalSeparator;
        $this->priceThousandSeparator = $priceThousandSeparator;
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

    /**
     * @return string
     */
    public function getPriceDecimalSeparator(): string
    {
        return $this->priceDecimalSeparator;
    }

    /**
     * @return string
     */
    public function getPriceThousandSeparator(): string
    {
        return $this->priceThousandSeparator;
    }
}

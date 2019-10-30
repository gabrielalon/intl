<?php

namespace N3ttech\Intl\Application\Country\Command;

class UpdateCountry extends Country
{
    /** @var string */
    private $continent;

    /** @var string */
    private $vatRate;

    /** @var string */
    private $dateFormat;

    /** @var string */
    private $timeFormat;

    /**
     * @param string $code
     * @param string $continent
     * @param string $vatRate
     * @param string $dateFormat
     * @param string $timeFormat
     */
    public function __construct(
        string $code,
        string $continent,
        string $vatRate,
        string $dateFormat = 'Y-m-d',
        string $timeFormat = 'H:i:s'
    ) {
        $this->setCode($code);
        $this->continent = $continent;
        $this->vatRate = $vatRate;
        $this->dateFormat = $dateFormat;
        $this->timeFormat = $timeFormat;
    }

    /**
     * @return string
     */
    public function getContinent(): string
    {
        return $this->continent;
    }

    /**
     * @return string
     */
    public function getVatRate(): string
    {
        return $this->vatRate;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * @return string
     */
    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }
}

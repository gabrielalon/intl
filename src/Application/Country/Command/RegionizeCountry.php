<?php

namespace N3ttech\Intl\Application\Country\Command;

class RegionizeCountry extends Country
{
    /** @var string[][] */
    private $regions;

    /**
     * @param string     $code
     * @param string[][] $regions
     */
    public function __construct(string $code, array $regions)
    {
        $this->setCode($code);
        $this->regions = $regions;
    }

    /**
     * @return string[][]
     */
    public function getRegions(): array
    {
        return $this->regions;
    }
}

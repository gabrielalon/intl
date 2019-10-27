<?php

namespace N3ttech\Intl\Application\Continent\Query\V1;

use N3ttech\Intl\Application\Continent\Query\ReadModel;
use N3ttech\Messaging\Query\Query\Query;

class FindOneByCode extends Query
{
    /** @var string */
    private $code;

    /** @var ReadModel\Continent */
    private $continent;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return ReadModel\Continent
     */
    public function getContinent(): ReadModel\Continent
    {
        return $this->continent;
    }

    /**
     * @param ReadModel\Continent $continent
     */
    public function setContinent(ReadModel\Continent $continent): void
    {
        $this->continent = $continent;
    }
}

<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

class FindOneByHost extends Query
{
    /** @var string */
    private $host;

    /**
     * @param string $host
     */
    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
}

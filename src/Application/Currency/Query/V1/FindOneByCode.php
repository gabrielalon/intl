<?php

namespace N3ttech\Intl\Application\Currency\Query\V1;

class FindOneByCode extends Query
{
    /** @var string */
    private $code;

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
}

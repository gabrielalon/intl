<?php

namespace N3ttech\Intl\Application\Country\Command;

class ActivateCountry extends Country
{
    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->setCode($code);
    }
}

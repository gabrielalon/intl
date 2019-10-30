<?php

namespace N3ttech\Intl\Application\Country\Command;

class DeactivateCountry extends Country
{
    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->setCode($code);
    }
}

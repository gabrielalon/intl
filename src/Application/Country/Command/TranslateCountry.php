<?php

namespace N3ttech\Intl\Application\Country\Command;

class TranslateCountry extends Country
{
    /** @var string[] */
    private $names;

    /**
     * @param string   $code
     * @param string[] $names
     */
    public function __construct(string $code, array $names = [])
    {
        $this->setCode($code);
        $this->names = $names;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}

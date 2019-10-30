<?php

namespace N3ttech\Intl\Application\Country\Command;

class InternationalizeCountry extends Country
{
    /** @var string[] */
    private $currencies;

    /** @var string[] */
    private $languages;

    /**
     * @param string   $code
     * @param string[] $currencies
     * @param string[] $languages
     */
    public function __construct(string $code, array $currencies, array $languages)
    {
        $this->setCode($code);
        $this->currencies = $currencies;
        $this->languages = $languages;
    }

    /**
     * @return string[]
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    /**
     * @return string[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }
}

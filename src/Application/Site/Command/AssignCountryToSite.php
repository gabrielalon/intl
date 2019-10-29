<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Messaging\Command\Command\Command;

class AssignCountryToSite extends Command
{
    /** @var string */
    private $uuid;

    /** @var string[] */
    private $countries;

    /**
     * @param string   $uuid
     * @param string[] $countries
     */
    public function __construct(string $uuid, array $countries = [])
    {
        $this->uuid = $uuid;
        $this->countries = $countries;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }
}

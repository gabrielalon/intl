<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

class FindOneByIdentity extends Query
{
    /** @var string */
    private $uuid;

    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}

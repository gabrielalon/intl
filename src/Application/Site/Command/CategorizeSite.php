<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Messaging\Command\Command\Command;

class CategorizeSite extends Command
{
    /** @var string */
    private $uuid;

    /** @var string[] */
    private $categories;

    /**
     * @param string   $uuid
     * @param string[] $categories
     */
    public function __construct(string $uuid, array $categories = [])
    {
        $this->uuid = $uuid;
        $this->categories = $categories;
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
    public function getCategories(): array
    {
        return $this->categories;
    }
}

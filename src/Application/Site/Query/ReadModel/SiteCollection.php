<?php

namespace N3ttech\Intl\Application\Site\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class SiteCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Site $site
     */
    public function add(Query\Viewable $site): void
    {
        $this->offsetSet($site->identifier(), $site);
    }

    /**
     * @param string $uuid
     *
     * @return Site
     */
    public function get(string $uuid): Site
    {
        return $this->offsetGet($uuid);
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public function has(string $uuid): bool
    {
        return $this->offsetExists($uuid);
    }

    /**
     * @param string $uuid
     */
    public function remove(string $uuid): void
    {
        $this->offsetUnset($uuid);
    }

    /**
     * @return Site[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

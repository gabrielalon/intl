<?php

namespace N3ttech\Intl\Application\Continent\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class ContinentCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Continent $site
     */
    public function add(Query\Viewable $site): void
    {
        $this->offsetSet($site->identifier(), $site);
    }

    /**
     * @param string $code
     *
     * @return Continent
     */
    public function get(string $code): Continent
    {
        return $this->offsetGet($code);
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function has(string $code): bool
    {
        return $this->offsetExists($code);
    }

    /**
     * @param string $code
     */
    public function remove(string $code): void
    {
        $this->offsetUnset($code);
    }

    /**
     * @return Continent[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

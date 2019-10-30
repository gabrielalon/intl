<?php

namespace N3ttech\Intl\Application\Country\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class CountryCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Country $country
     */
    public function add(Query\Viewable $country): void
    {
        $this->offsetSet($country->identifier(), $country);
    }

    /**
     * @param string $uuid
     *
     * @return Country
     */
    public function get(string $uuid): Country
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
     * @return Country[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

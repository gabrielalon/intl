<?php

namespace N3ttech\Intl\Application\Currency\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class CurrencyCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Currency $currency
     */
    public function add(Query\Viewable $currency): void
    {
        $this->offsetSet($currency->identifier(), $currency);
    }

    /**
     * @param string $uuid
     *
     * @return Currency
     */
    public function get(string $uuid): Currency
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
     * @return Currency[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

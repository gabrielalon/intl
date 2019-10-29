<?php

namespace N3ttech\Intl\Application\VatRate\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class VatRateCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param VatRate $vatRate
     */
    public function add(Query\Viewable $vatRate): void
    {
        $this->offsetSet($vatRate->identifier(), $vatRate);
    }

    /**
     * @param string $uuid
     *
     * @return VatRate
     */
    public function get(string $uuid): VatRate
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
     * @return VatRate[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

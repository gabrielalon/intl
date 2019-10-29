<?php

namespace N3ttech\Intl\Application\Language\Query\ReadModel;

use N3ttech\Messaging\Query\Query;

class LanguageCollection extends \ArrayIterator implements Query\ViewableCollection
{
    /**
     * @param Language $site
     */
    public function add(Query\Viewable $site): void
    {
        $this->offsetSet($site->identifier(), $site);
    }

    /**
     * @param string $locale
     *
     * @return Language
     */
    public function get(string $locale): Language
    {
        return $this->offsetGet($locale);
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    public function has(string $locale): bool
    {
        return $this->offsetExists($locale);
    }

    /**
     * @param string $locale
     */
    public function remove(string $locale): void
    {
        $this->offsetUnset($locale);
    }

    /**
     * @return Language[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

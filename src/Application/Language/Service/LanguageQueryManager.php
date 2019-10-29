<?php

namespace N3ttech\Intl\Application\Language\Service;

use N3ttech\Intl\Application\Language\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class LanguageQueryManager extends QueryManager
{
    /**
     * @param string $locale
     *
     * @return Query\ReadModel\Language
     */
    public function findOneByLocale(string $locale): Query\ReadModel\Language
    {
        $query = new Query\V1\FindOneByLocale($locale);

        $this->ask($query);

        if (false == $query->getLanguage() instanceof Query\ReadModel\Language) {
            throw new Exception\ResourceNotFoundException(\sprintf(
                'Language not found by locale %s.',
                $locale
            ));
        }

        return $query->getLanguage();
    }
}

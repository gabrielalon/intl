<?php

namespace N3ttech\Intl\Application\Currency\Service;

use N3ttech\Intl\Application\Currency\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class CurrencyQueryManager extends QueryManager
{
    /**
     * @param string $code
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Currency
     */
    public function findOneByCode(string $code): Query\ReadModel\Currency
    {
        $query = new Query\V1\FindOneByCode($code);

        $this->ask($query);

        if (false == $query->getCurrency() instanceof Query\ReadModel\Currency) {
            throw new Exception\ResourceNotFoundException(\sprintf('Currency not found by code %s.', $code));
        }

        return $query->getCurrency();
    }
}

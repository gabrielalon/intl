<?php

namespace N3ttech\Intl\Application\Continent\Service;

use N3ttech\Intl\Application\Continent\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class ContinentQueryManager extends QueryManager
{
    /**
     * @param string $code
     *
     * @return Query\ReadModel\Continent
     */
    public function findOneByCode(string $code): Query\ReadModel\Continent
    {
        $query = new Query\V1\FindOneByCode($code);

        $this->ask($query);

        if (false == $query->getContinent() instanceof Query\ReadModel\Continent) {
            throw new Exception\ResourceNotFoundException(\sprintf('Continent not found by code %s.', $code));
        }

        return $query->getContinent();
    }
}

<?php

namespace N3ttech\Intl\Application\Country\Service;

use N3ttech\Intl\Application\Country\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class CountryQueryManager extends QueryManager
{
    /**
     * @param string $code
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Country
     */
    public function findOneByCode(string $code): Query\ReadModel\Country
    {
        $query = new Query\V1\FindOneByCode($code);

        $this->ask($query);

        if (false == $query->getCountry() instanceof Query\ReadModel\Country) {
            throw new Exception\ResourceNotFoundException(\sprintf(
                'Country not found by code %s.',
                $code
            ));
        }

        return $query->getCountry();
    }

    /**
     * @return Query\ReadModel\CountryCollection
     */
    public function findAllActive(): Query\ReadModel\CountryCollection
    {
        $query = new Query\V1\FindAllActive();

        $this->ask($query);

        return $query->getCollection();
    }
}

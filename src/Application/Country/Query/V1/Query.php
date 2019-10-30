<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

use N3ttech\Intl\Application\Country\Query\ReadModel;

abstract class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var ReadModel\Country */
    private $country;

    /** @var ReadModel\CountryCollection */
    private $collection;

    /**
     * @return ReadModel\Country
     */
    public function getCountry(): ReadModel\Country
    {
        return $this->country;
    }

    /**
     * @param ReadModel\Country $country
     */
    public function setCountry(ReadModel\Country $country)
    {
        $this->country = $country;
    }

    /**
     * @return ReadModel\CountryCollection
     */
    public function getCollection(): ReadModel\CountryCollection
    {
        return $this->collection;
    }

    /**
     * @param ReadModel\CountryCollection $collection
     */
    public function setCollection(ReadModel\CountryCollection $collection): void
    {
        $this->collection = $collection;
    }
}

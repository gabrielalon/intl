<?php

namespace N3ttech\Intl\Application\Country\Query\V1;

use N3ttech\Intl\Application\Country\Query\ReadModel\CountryCollection;

class FindAllActive extends Query
{
    public function __construct()
    {
        $this->setCollection(new CountryCollection());
    }
}

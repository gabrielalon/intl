<?php

namespace N3ttech\Intl\Infrastructure\Query\Country\Filter;

use N3ttech\Intl\Application\Country\Query\ReadModel;

class ActiveIterator extends \FilterIterator
{
    /**
     * @return bool
     */
    public function accept()
    {
        /** @var ReadModel\Country $country */
        $country = $this->getInnerIterator()->current();

        return $country->isActive();
    }
}

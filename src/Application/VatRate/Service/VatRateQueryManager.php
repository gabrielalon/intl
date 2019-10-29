<?php

namespace N3ttech\Intl\Application\VatRate\Service;

use N3ttech\Intl\Application\VatRate\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class VatRateQueryManager extends QueryManager
{
    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\VatRate
     */
    public function findOneByIdentity(string $uuid): Query\ReadModel\VatRate
    {
        $query = new Query\V1\FindOneByIdentity($uuid);

        $this->ask($query);

        if (false == $query->getVatRate() instanceof Query\ReadModel\VatRate) {
            throw new Exception\ResourceNotFoundException(\sprintf(
                'VatRate not found by identity %s.',
                $uuid
            ));
        }

        return $query->getVatRate();
    }
}

<?php

namespace N3ttech\Intl\Application\VatRate\Query\V1;

use N3ttech\Intl\Application\VatRate\Query\ReadModel\VatRate;

abstract class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var VatRate */
    private $vatRate;

    /**
     * @return VatRate
     */
    public function getVatRate(): VatRate
    {
        return $this->vatRate;
    }

    /**
     * @param VatRate $vatRate
     */
    public function setVatRate(VatRate $vatRate)
    {
        $this->vatRate = $vatRate;
    }
}

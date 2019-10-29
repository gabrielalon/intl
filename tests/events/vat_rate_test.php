<?php

use N3ttech\Intl\Application\VatRate;

return [
    VatRate\Event\ExistingVatRateRefreshed::class => [\N3ttech\Intl\Domain\Model\VatRate\Projection\VatRateProjection::class],
    VatRate\Event\ExistingVatRateTranslated::class => [\N3ttech\Intl\Domain\Model\VatRate\Projection\VatRateProjection::class],
    VatRate\Event\ExistingVatRateRemoved::class => [\N3ttech\Intl\Domain\Model\VatRate\Projection\VatRateProjection::class],
    VatRate\Event\NewVatRateCreated::class => [\N3ttech\Intl\Domain\Model\VatRate\Projection\VatRateProjection::class],
];

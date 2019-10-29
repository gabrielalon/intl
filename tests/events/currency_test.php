<?php

use N3ttech\Intl\Application\Currency;

return [
    Currency\Event\ExistingCurrencyRefreshed::class => [\N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection::class],
    Currency\Event\ExistingCurrencyTranslated::class => [\N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection::class],
    Currency\Event\ExistingCurrencyRemoved::class => [\N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection::class],
    Currency\Event\ExistingCurrencyUpdated::class => [\N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection::class],
    Currency\Event\NewCurrencyCreated::class => [\N3ttech\Intl\Domain\Model\Currency\Projection\CurrencyProjection::class],
];

<?php

use N3ttech\Intl\Application\Continent;

return [
    Continent\Event\ExistingContinentTranslated::class => [\N3ttech\Intl\Domain\Model\Continent\Projection\ContinentProjection::class],
    Continent\Event\ExistingContinentRemoved::class => [\N3ttech\Intl\Domain\Model\Continent\Projection\ContinentProjection::class],
    Continent\Event\NewContinentCreated::class => [\N3ttech\Intl\Domain\Model\Continent\Projection\ContinentProjection::class],
];

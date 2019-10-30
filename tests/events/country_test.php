<?php

use N3ttech\Intl\Application\Country;

return [
    Country\Event\ExistingCountryDeactivated::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryActivated::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryRegionized::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryInternationalized::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryTranslated::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryRemoved::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\ExistingCountryUpdated::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
    Country\Event\NewCountryCreated::class => [\N3ttech\Intl\Domain\Model\Country\Projection\CountryProjection::class],
];

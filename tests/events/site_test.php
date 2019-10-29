<?php

use N3ttech\Intl\Application\Site;

return [
    Site\Event\CountriesToSiteAssigned::class => [\N3ttech\Intl\Domain\Model\Site\Projection\SiteProjection::class],
    Site\Event\ExistingSiteFlagged::class => [\N3ttech\Intl\Domain\Model\Site\Projection\SiteProjection::class],
    Site\Event\ExistingSiteRemoved::class => [\N3ttech\Intl\Domain\Model\Site\Projection\SiteProjection::class],
    Site\Event\NewSiteCreated::class => [\N3ttech\Intl\Domain\Model\Site\Projection\SiteProjection::class],
];

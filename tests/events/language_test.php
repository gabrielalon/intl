<?php

use N3ttech\Intl\Application\Language;

return [
    Language\Event\ExistingLanguageTranslated::class => [\N3ttech\Intl\Domain\Model\Language\Projection\LanguageProjection::class],
    Language\Event\ExistingLanguageRemoved::class => [\N3ttech\Intl\Domain\Model\Language\Projection\LanguageProjection::class],
    Language\Event\NewLanguageCreated::class => [\N3ttech\Intl\Domain\Model\Language\Projection\LanguageProjection::class],
];

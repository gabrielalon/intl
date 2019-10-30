<?php

namespace N3ttech\Intl\Test\Application\Language\Query;

use N3ttech\Intl\Application\Language\Query;
use N3ttech\Intl\Application\Language\Service;
use N3ttech\Intl\Infrastructure\Query\Language\InMemoryLanguageQuery;
use N3ttech\Intl\Test\Application\HandlerTestCase;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class V1QueryHandlerTest extends HandlerTestCase
{
    /** @var Query\ReadModel\Language */
    private $language;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->language = Query\ReadModel\Language::fromLocale('eu')
            ->setNames(VO\Intl\Language\Texts::fromArray(['pl' => 'Europa', 'en' => 'Europe']))
        ;

        $collection = new Query\ReadModel\LanguageCollection();
        $collection->add($this->language);

        $languageQuery = new InMemoryLanguageQuery($collection);
        $this->register(Query\V1\FindOneByLocaleHandler::class, new Query\V1\FindOneByLocaleHandler($languageQuery));
    }

    /**
     * @test
     */
    public function isFindsLanguageByLocale()
    {
        $manager = new Service\LanguageQueryManager($this->getQueryBus());

        $language = $manager->findOneByLocale($this->language->identifier());

        $this->assertTrue($language->getLocale()->equals($this->language->getLocale()));
    }
}

<?php

namespace N3ttech\Intl\Infrastructure\Projection\Language;

use N3ttech\Intl\Application\Language\Event;
use N3ttech\Intl\Application\Language\Query\ReadModel;
use N3ttech\Intl\Domain\Model\Language\Projection;

class InMemoryLanguageProjector implements Projection\LanguageProjection
{
    /** @var ReadModel\LanguageCollection */
    private $entities;

    /**
     * @param ReadModel\LanguageCollection|null $entities
     */
    public function __construct(ReadModel\LanguageCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\LanguageCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onNewLanguageCreated(Event\NewLanguageCreated $event): void
    {
        $this->entities->add(
            ReadModel\Language::fromLocale($event->aggregateId())
                ->setNames($event->languageNames())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingLanguageTranslated(Event\ExistingLanguageTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $language = $this->entities->get($event->aggregateId())
            ->setNames($event->languageNames())
        ;

        $this->entities->add($language);
    }

    /**
     * {@inheritdoc}
     */
    public function onExistingLanguageRemoved(Event\ExistingLanguageRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $locale
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Language
     */
    public function get(string $locale): ReadModel\Language
    {
        $this->checkExistence($locale);

        return $this->entities->get($locale);
    }

    /**
     * @param string $locale
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $locale): void
    {
        if (false === $this->entities->has($locale)) {
            throw new \RuntimeException(\sprintf('Language does not exists on given locale: %s', $locale));
        }
    }
}

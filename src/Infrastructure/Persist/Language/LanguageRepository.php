<?php

namespace N3ttech\Intl\Infrastructure\Persist\Language;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class LanguageRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Language::class;
    }

    /**
     * @param Language $continent
     *
     * @throws \Exception
     */
    public function save(Language $continent): void
    {
        $this->saveAggregateRoot($continent);
    }

    /**
     * @param string $code
     *
     * @return AggregateRoot|Language
     *
     * @throws \Assert\AssertionFailedException
     */
    public function find(string $code): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Intl\Language\Code::fromCode($code));
    }
}

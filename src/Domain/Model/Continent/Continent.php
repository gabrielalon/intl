<?php

namespace N3ttech\Intl\Domain\Model\Continent;

use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Messaging\Aggregate;
use N3ttech\Valuing as VO;

class Continent extends Aggregate\AggregateRoot
{
    /** @var VO\Intl\Locales */
    private $names;

    /**
     * @param Continent\Code $code
     *
     * @return Continent
     */
    public function setCode(Continent\Code $code): Continent
    {
        $this->setAggregateId($code);

        return $this;
    }

    /**
     * @param VO\Intl\Locales $names
     *
     * @return Continent
     */
    public function setNames(VO\Intl\Locales $names): Continent
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param Continent\Code  $code
     * @param VO\Intl\Locales $names
     *
     * @return Continent
     */
    public static function createNewContinent(Continent\Code $code, VO\Intl\Locales $names): Continent
    {
        $continent = new static();

        $continent->recordThat(Event\NewContinentCreated::occur($code->toString(), [
            'names' => $names->raw(),
        ]));

        return $continent;
    }

    /**
     * @param VO\Intl\Locales $names
     */
    public function update(VO\Intl\Locales $names): void
    {
        $this->recordThat(Event\ExistingContinentUpdated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingContinentRemoved::occur($this->aggregateId()));
    }
}

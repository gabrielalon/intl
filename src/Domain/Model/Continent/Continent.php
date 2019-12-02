<?php

namespace N3ttech\Intl\Domain\Model\Continent;

use N3ttech\Intl\Application\Continent\Event;
use N3ttech\Messaging\Aggregate;
use N3ttech\Valuing as VO;

class Continent extends Aggregate\AggregateRoot
{
    /** @var VO\Intl\Language\Texts */
    private $names;

    /**
     * @param VO\Intl\Continent\Code $code
     *
     * @return Continent
     */
    public function setCode(VO\Intl\Continent\Code $code): Continent
    {
        $this->setAggregateId($code);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Continent
     */
    public function setNames(VO\Intl\Language\Texts $names): Continent
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Intl\Continent\Code $code
     * @param VO\Intl\Language\Texts $names
     *
     * @return Continent
     */
    public static function createNewContinent(VO\Intl\Continent\Code $code, VO\Intl\Language\Texts $names): Continent
    {
        $continent = new static();

        $continent->recordThat(Event\NewContinentCreated::occur($code->toString(), [
            'names' => $names->raw(),
        ]));

        return $continent;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     */
    public function translate(VO\Intl\Language\Texts $names): void
    {
        $this->recordThat(Event\ExistingContinentTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingContinentRemoved::occur($this->aggregateId()));
    }
}

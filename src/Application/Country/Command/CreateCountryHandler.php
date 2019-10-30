<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateCountryHandler extends CountryHandler
{
    /**
     * @param CreateCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Country::createNewCountry(
            VO\Intl\Country\Code::fromCode($command->getCode()),
            VO\Intl\Continent\Code::fromCode($command->getContinent()),
            VO\Identity\Uuid::fromIdentity($command->getVatRate()),
            VO\Char\Text::fromString($command->getDateFormat()),
            VO\Char\Text::fromString($command->getTimeFormat())
        ));
    }
}

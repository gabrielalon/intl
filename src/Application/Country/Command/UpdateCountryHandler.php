<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class UpdateCountryHandler extends CountryHandler
{
    /**
     * @param UpdateCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Country $country */
        $country = $this->repository->find($command->getCode());

        $country->update(
            VO\Intl\Continent\Code::fromCode($command->getContinent()),
            VO\Identity\Uuid::fromIdentity($command->getVatRate()),
            VO\Char\Text::fromString($command->getDateFormat()),
            VO\Char\Text::fromString($command->getTimeFormat())
        );

        $this->repository->save($country);
    }
}

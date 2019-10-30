<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;

class ActivateCountryHandler extends CountryHandler
{
    /**
     * @param ActivateCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Country $country */
        $country = $this->repository->find($command->getCode());

        $country->activate();

        $this->repository->save($country);
    }
}

<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class InternationalizeCountryHandler extends CountryHandler
{
    /**
     * @param InternationalizeCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Country $country */
        $country = $this->repository->find($command->getCode());

        $country->internationalize(
            VO\Intl\Currency\Codes::fromArray($command->getCurrencies()),
            VO\Intl\Language\Codes::fromArray($command->getLanguages())
        );

        $this->repository->save($country);
    }
}

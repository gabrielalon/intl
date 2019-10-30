<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateCountryHandler extends CountryHandler
{
    /**
     * @param TranslateCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Country $country */
        $country = $this->repository->find($command->getCode());

        $country->translate(VO\Intl\Language\Texts::fromArray($command->getNames()));

        $this->repository->save($country);
    }
}

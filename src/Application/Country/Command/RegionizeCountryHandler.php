<?php

namespace N3ttech\Intl\Application\Country\Command;

use N3ttech\Intl\Domain\Model\Country\Country;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class RegionizeCountryHandler extends CountryHandler
{
    /**
     * @param RegionizeCountry $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Country $country */
        $country = $this->repository->find($command->getCode());

        $country->regionize(VO\Intl\Country\Regions::fromArray($command->getRegions()));

        $this->repository->save($country);
    }
}

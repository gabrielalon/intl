<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class AssignCountryToSiteHandler extends SiteHandler
{
    /**
     * @param AssignCountryToSite $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Site $site */
        $site = $this->repository->find($command->getUuid());

        $site->countriesAssigned(VO\Intl\Country\Codes::fromArray($command->getCountries()));

        $this->repository->save($site);
    }
}

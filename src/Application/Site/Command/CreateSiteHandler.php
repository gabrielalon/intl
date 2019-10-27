<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateSiteHandler extends SiteHandler
{
    /**
     * @param CreateSite $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Site::createNewSite(
            VO\Identity\Uuid::fromIdentity($command->getUuid()),
            VO\Char\Text::fromString($command->getHost()),
            VO\Option\Check::fromBoolean($command->isMobile()),
            VO\Option\Check::fromBoolean($command->isAuth())
        ));
    }
}

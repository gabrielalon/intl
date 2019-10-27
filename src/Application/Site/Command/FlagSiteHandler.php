<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class FlagSiteHandler extends SiteHandler
{
    /**
     * @param FlagSite $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Site $site */
        $site = $this->repository->find($command->getUuid());

        $site->flagged(
            VO\Option\Check::fromBoolean($command->isMobile()),
            VO\Option\Check::fromBoolean($command->isAuth())
        );

        $this->repository->save($site);
    }
}

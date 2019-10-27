<?php

namespace N3ttech\Intl\Application\Site\Command;

use N3ttech\Intl\Domain\Model\Site\Site;
use N3ttech\Messaging\Message\Domain\Message;

class RemoveSiteHandler extends SiteHandler
{
    /**
     * @param RemoveSite $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Site $site */
        $site = $this->repository->find($command->getUuid());

        $site->remove();

        $this->repository->save($site);
    }
}

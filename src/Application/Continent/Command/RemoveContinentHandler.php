<?php

namespace N3ttech\Intl\Application\Continent\Command;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Message\Domain\Message;

class RemoveContinentHandler extends ContinentHandler
{
    /**
     * @param RemoveContinent $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Continent $site */
        $site = $this->repository->find($command->getCode());

        $site->remove();

        $this->repository->save($site);
    }
}

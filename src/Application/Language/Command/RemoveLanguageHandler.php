<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Message\Domain\Message;

class RemoveLanguageHandler extends LanguageHandler
{
    /**
     * @param RemoveLanguage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Language $site */
        $site = $this->repository->find($command->getCode());

        $site->remove();

        $this->repository->save($site);
    }
}

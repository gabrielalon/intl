<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateLanguageHandler extends LanguageHandler
{
    /**
     * @param TranslateLanguage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Language $site */
        $site = $this->repository->find($command->getCode());

        $site->translate(VO\Intl\Language\Texts::fromArray($command->getNames()));

        $this->repository->save($site);
    }
}

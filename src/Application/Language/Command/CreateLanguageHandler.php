<?php

namespace N3ttech\Intl\Application\Language\Command;

use N3ttech\Intl\Domain\Model\Language\Language;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateLanguageHandler extends LanguageHandler
{
    /**
     * @param CreateLanguage $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Language::createNewLanguage(
            VO\Intl\Language\Locale::fromLocale($command->getLocale()),
            VO\Intl\Language\Locales::fromArray($command->getNames())
        ));
    }
}

<?php

namespace N3ttech\Intl\Application\Continent\Command;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class TranslateContinentHandler extends ContinentHandler
{
    /**
     * @param TranslateContinent $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        /** @var Continent $site */
        $site = $this->repository->find($command->getCode());

        $site->translate(VO\Intl\Language\Texts::fromArray($command->getNames()));

        $this->repository->save($site);
    }
}

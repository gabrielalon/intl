<?php

namespace N3ttech\Intl\Application\Continent\Command;

use N3ttech\Intl\Domain\Model\Continent\Continent;
use N3ttech\Messaging\Message\Domain\Message;
use N3ttech\Valuing as VO;

class CreateContinentHandler extends ContinentHandler
{
    /**
     * @param CreateContinent $command
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function run(Message $command): void
    {
        $this->repository->save(Continent::createNewContinent(
            VO\Intl\Continent\Code::fromCode($command->getCode()),
            VO\Intl\Language\Texts::fromArray($command->getNames())
        ));
    }
}

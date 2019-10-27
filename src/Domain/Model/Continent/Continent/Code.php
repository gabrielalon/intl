<?php

namespace N3ttech\Intl\Domain\Model\Continent\Continent;

use Assert\Assertion;
use N3ttech\Valuing\Identity\AggregateId;
use N3ttech\Valuing\VO;

class Code extends VO implements AggregateId
{
    /**
     * @param string $code
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Code
     */
    public static function fromString(string $code): Code
    {
        return new Code($code);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function guard($code): void
    {
        Assertion::regex($code, '/[a-zA-Z]{2}/', 'Invalid Continent code: '.$code);
    }
}

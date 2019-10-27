<?php

namespace N3ttech\Intl\Infrastructure\Query\Site\Filter;

use N3ttech\Intl\Application\Site\Query\ReadModel;
use N3ttech\Valuing as VO;

class HostIterator extends \FilterIterator
{
    /** @var VO\Char\Text */
    private $host;

    /**
     * @param string $host
     *
     * @throws \Assert\AssertionFailedException
     */
    public function setHost(string $host): void
    {
        $this->host = VO\Char\Text::fromString($host);
    }

    /**
     * @return bool
     */
    public function accept()
    {
        /** @var ReadModel\Site $site */
        $site = $this->getInnerIterator()->current();

        return $site->getHost()->equals($this->host);
    }
}

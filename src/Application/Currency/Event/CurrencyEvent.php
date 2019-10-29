<?php

namespace N3ttech\Intl\Application\Currency\Event;

use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

abstract class CurrencyEvent extends AggregateChanged
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Intl\Currency\Code
     */
    public function currencyCode(): VO\Intl\Currency\Code
    {
        return VO\Intl\Currency\Code::fromCode($this->aggregateId());
    }
}

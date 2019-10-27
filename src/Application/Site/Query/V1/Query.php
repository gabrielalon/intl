<?php

namespace N3ttech\Intl\Application\Site\Query\V1;

use N3ttech\Intl\Application\Site\Query\ReadModel\Site;

abstract class Query extends \N3ttech\Messaging\Query\Query\Query
{
    /** @var Site */
    private $site;

    /**
     * @return Site
     */
    public function getSite(): Site
    {
        return $this->site;
    }

    /**
     * @param Site $site
     */
    public function setSite(Site $site)
    {
        $this->site = $site;
    }
}

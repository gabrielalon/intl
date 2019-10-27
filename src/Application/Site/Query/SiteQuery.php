<?php

namespace N3ttech\Intl\Application\Site\Query;

use N3ttech\Intl\Application\Site\Query\ReadModel\Site;
use N3ttech\Messaging\Query\Query\Query;

class SiteQuery extends Query
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
     *
     * @return SiteQuery
     */
    public function setSite(Site $site): SiteQuery
    {
        $this->site = $site;
    }
}

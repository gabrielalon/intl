<?php

namespace N3ttech\Intl\Application\Site\Service;

use N3ttech\Intl\Application\Site\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class SiteQueryManager extends QueryManager
{
    /**
     * @param string $host
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Site
     */
    public function findOneByHost(string $host): Query\ReadModel\Site
    {
        $query = new Query\V1\FindOneByHost($host);

        $this->ask($query);

        if (false == $query->getSite() instanceof Query\ReadModel\Site) {
            throw new Exception\ResourceNotFoundException(\sprintf('Site not found by host %s.', $host));
        }

        return $query->getSite();
    }

    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Site
     */
    public function findOneByIdentity(string $uuid): Query\ReadModel\Site
    {
        $query = new Query\V1\FindOneByIdentity($uuid);

        $this->ask($query);

        if (false == $query->getSite() instanceof Query\ReadModel\Site) {
            throw new Exception\ResourceNotFoundException(\sprintf('Site not found by identity %s.', $uuid));
        }

        return $query->getSite();
    }
}

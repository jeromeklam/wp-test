<?php

/**
 * The animals locations (private access)
 *
 * @author jeromeklam
 */
class Freeasso_Api_Sites extends Freeasso_Api_Base
{

    /**
     * Sites
     *
     * @var array
     */
    protected $sites = null;

    /**
     * Get all sites
     *
     * @return array
     */
    public function getSites()
    {
        if ($this->sites === null) {
            $this->getWS();
        }
        return $this->sites;
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct();
        $this->setMethod(self::FREEASSO_METHOD_GET)->setUrl('/v1/asso/site');
        $this->setPrivate();
    }

    /**
     * Set sites
     *
     * @param array $p_sites
     *
     * @return Freeasso_Api_Sites
     */
    protected function setSites($p_sites)
    {
        $this->sites = $p_sites;
        return $this;
    }

    /**
     * Call WS
     *
     * @return boolean
     */
    protected function getWS()
    {
        $result = $this->call();
        if ($result && is_array($result)) {
            $this->setSites($result);
            return true;
        }
        $this->setSites([]);
        return false;
    }
}
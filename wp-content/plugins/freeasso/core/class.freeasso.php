<?php

/**
 * FreeAsso generic
 *
 * @author jeromeklam
 *
 */
class Freeasso
{

    /**
     * Instance
     * @var Freeasso
     */
    private static $instance = null;

    /**
     * Config, just for fun, it's a singleton
     * @var Freeasso_Config
     */
    private $config = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->config = Freeasso_Config::getInstance();
    }

    /**
     * Get instance
     *
     * @return Freeasso
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * init to keep standard logic, but it's getInstance...
     *
     * @return Freeasso
     */
    public static function init()
    {
        return self::getInstance();
    }

    /**
     * Get global FreeAsso config
     *
     * @return Freeasso_Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Replace stats placeholders by real content
     *
     * @param string $p_content
     *
     * @return string
     */
    public static function filterStats($p_content)
    {
        $stats = Freeasso_Api_Stats::getFactory();
        $content = $p_content;
        if ($stats) {
            $content = $stats->regExpReplace($content);
        }
        return $content;
    }
}

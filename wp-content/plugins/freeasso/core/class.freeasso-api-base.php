<?php

/**
 * Api base class
 *
 * @author jeromeklam
 *
 */
class Freeasso_Api_Base {

    /**
     * Methods
     * @var string
     */
    const FREEASSO_METHOD_GET = 'get';
    const FREEASSO_METHOD_PUT = 'put';
    const FREEASSO_METHOD_POST = 'post';
    const FREEASSO_METHOD_DELETE = 'delete';
    const FREEASSO_METHOD_HEAD = 'head';
    const FREEASSO_METHOD_OPTIONS = 'options';

    /**
     * Config
     * @var Freeasso_Config
     */
    private $config = null;

    /**
     * Method
     * @var FREEASSO_METHOD_*
     */
    private $method = null;

    /**
     * Url to call
     * @var string
     */
    private $url = null;

    /**
     * Private or public route ?
     * @var boolean
     */
    private $public = false;


    /**
     * Get factory
     *
     * @return Freeasso_Api_Base
     */
    public static function getFactory()
    {
        $ws = new static();
        return $ws;
    }


    /**
     * Replace pattern
     *
     * @param string $p_string
     * @param string $p_regex
     *
     * @return string
     */
    public function regExpReplace($p_string, $p_regex = null)
    {
        if ($p_regex === null) {
            $p_regex = Freeasso_Tools::REGEX_PARAM_PLACEHOLDER;
        }
        $matches = [];
        if (0 < preg_match_all($p_regex, $p_string, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $replace = '';
                $method = $this->getMethodFromMatch($match[1]);
                if (method_exists($this, $method)) {
                    $replace = $this->{$method}();
                }
                $p_string = str_replace(
                    $match[0],
                    $replace,
                    $p_string
                    );
            }
        }
        return $p_string;
    }

    /**
     * Get method from matching pattern
     *
     * @param string $p_match
     *
     * @return string
     */
    protected function getMethodFromMatch($p_match)
    {
        $p_match = strtolower($p_match);
        $p_match = str_replace('freeasso', '', $p_match);
        $p_match = trim($p_match, '_');
        return 'get' . Freeasso_Tools::toCamelCase($p_match, true);
    }

    /**
     * Constructor
     */
    protected function __construct()
    {
        $freeasso = Freeasso::getInstance();
        $this->config = $freeasso->getConfig();
        if (!$this->config instanceof Freeasso_Config) {
            throw new \Exception("Class Freeasso_Config not found !");
        }
    }

    /**
     * Get config
     *
     * @return Freeasso_Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * Get Full WS url
     *
     * @return string
     */
    protected function getFullUrl()
    {
        $url = rtrim($this->getConfig()->getWsBaseUrl(), "/");
        return $url . '/' . ltrim($this->url, '/');
    }

    /**
     * Set method
     *
     * @param string $p_method
     *
     * @return Freeasso_Api_Base
     */
    protected function setMethod($p_method)
    {
        $this->method = $p_method;
        return $this;
    }

    /**
     * Get method
     *
     * @return FREEASSO_METHOD_*
     */
    protected function getMethod()
    {
        return $this->method;
    }

    /**
     * Set url
     *
     * @param string $p_url
     *
     * @return Freeasso_Api_Base
     */
    protected function setUrl($p_url)
    {
        $this->url  = $p_url;
        return $this;
    }

    /**
     * Return url
     *
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * Set public route
     *
     * @param boolean $p_public
     *
     * @return Freeasso_Api_Base
     */
    protected function setPublic($p_public = true)
    {
        $this->public = $p_public;
        return $this;
    }

    /**
     * Set private route
     *
     * @param boolean $p_public
     *
     * @return Freeasso_Api_Base
     */
    protected function setPrivate($p_public = false)
    {
        $this->public = $p_public;
        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    protected function getPublic()
    {
        return $this->public;
    }

    /**
     * Public ??
     *
     * @return boolean
     */
    protected function isPublic()
    {
        return $this->public === true;
    }

    /**
     * Private ??
     *
     * @return boolean
     */
    protected function isPrivate()
    {
        return $this->public === false;
    }

    /**
     * Get Hawk auth header
     *
     * @return string
     */
    protected function getHawkAuth()
    {
        $ts = $this->getTs();
        $nonce = $this->getNonce();
        $hawk = $this->getHawkArray($ts, $nonce);
        $hawkStr = implode("\n", $hawk);
        $hash = hash_hmac('sha256', $hawkStr, $this->getConfig()->getHawkKey(), true);
        $auth = 'Hawk ' .
               'id=' . $this->getConfig()->getHawkUser() . ', ' .
               'ts=' . $ts . ', ' .
               'nonce=' . $nonce . ', ' .
               'mac=' . base64_encode($hash)
        ;
        return $auth;
    }

    /**
     * Get base url scheme
     *
     * @return string
     */
    protected function getUrlScheme()
    {
        $url = strtolower($this->getConfig()->getWsBaseUrl());
        $parts = parse_url($url);
        if (is_array($parts) && array_key_exists('scheme', $parts)) {
            return strtolower($parts['scheme']);
        }
        return 'http';
    }

    /**
     * Get base url host
     *
     * @return string
     */
    protected function getUrlHost()
    {
        $url = $this->getConfig()->getWsBaseUrl();
        $parts = parse_url($url);
        if (is_array($parts) && array_key_exists('host', $parts)) {
            return strtolower($parts['host']);
        }
        return '';
    }

    /**
     * Get base url path
     *
     * @return string
     */
    protected function getUrlPath()
    {
        $url = $this->getFullUrl();
        $parts = parse_url($url);
        $result = '';
        if (is_array($parts) && array_key_exists('path', $parts)) {
            $result = strtolower($parts['path']);
        }
        return $result;
    }

    /**
     * Get base url port
     *
     * @return number
     */
    protected function getUrlPort()
    {
        $url = $this->getConfig()->getWsBaseUrl();
        $parts = parse_url($url);
        $port = false;
        if (is_array($parts) && array_key_exists(PHP_URL_PORT, $parts)) {
            $port = $parts[PHP_URL_PORT];
        }
        if ($port === false) {
            $port = 80;
            if ($this->getUrlScheme() === 'https') {
                $port = 443;
            }
        }
        return intval($port);
    }

    /**
     * Get TS
     *
     * @return string
     */
    protected function getTs()
    {
        $parts =  explode('.', microtime(true));
        return $parts[0];
    }

    /**
     * Get nonce
     *
     * @return string
     */
    protected function getNonce()
    {
        return substr(md5(microtime()), 0, 6);
    }

    /**
     * get Hawk parts as array
     *
     * @param string $p_ts
     * @param string $p_nonce
     *
     * @return array
     */
    protected function getHawkArray($p_ts, $p_nonce)
    {
        $hawk = [];
        $hawk[] = 'hawk.1.header';
        $hawk[] = $p_ts;
        $hawk[] = $p_nonce;
        $hawk[] = strtoupper($this->getMethod());
        $hawk[] = $this->getUrlPath();
        $hawk[] = $this->getUrlHost();
        $hawk[] = $this->getUrlPort();
        $hawk[] = '';
        $hawk[] = '';
        $hawk[] = '';
        $hawk[] = '';
        return $hawk;
    }

    /**
     * Call WS
     */
    protected function call()
    {
        $args = [
            'headers' => [
                'Api-Id' => $this->getConfig()->getApiId(),
                'Accept' => 'application/json',  // Just accept json result, no jsonapi
                'Content-Type' => 'application/json' // Force json content
            ]
        ];
        if ($this->isPrivate()) {
            $args['headers']['Authorization'] = $this->getHawkAuth();
        }
        $result = wp_remote_get($this->getFullUrl(), $args );
        var_dump($result);
        die;
        if ($result && array_key_exists('body', $result)) {
            $json = $result['body'];
            return json_decode($json);
        }
        return false;
    }
}

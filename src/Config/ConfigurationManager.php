<?php

namespace Esier\Config;

class ConfigurationManager
{
    /*
    *	Static instance of the object
    *
    *	@var Esier\Config\ConfigurationManager
    */
    private static $instance;

    /*
    *	Currentconfiguration
    *
    *	@var Esier\Config\ConfigurationContainer
    */
    protected $configuration;

    /*
    *	Configuration Manager constructor
    *
    *	@return void
    */
    private function __construct()
    {
        $this->configuration = new ConfigurationContainer(require_once __DIR__.'/Configuration.php');
    }

    /*
    *	Get the single instance of configuration
    *
    *	@return Esier\Config\ConfigurationContainer
    */
    public static function getInstance() : self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
    *	Get the current configuration
    *
    *	@return Esier\Config\ConfigurationContainer
    */
    public function getConfiguration() : ConfigurationContainer
    {
        return $this->configuration;
    }

    /*
    *	Update the configuration with an entirely new instance
    *
    *	@param Esier\Config\ConfigurationContainer
    *
    *	@return void
    *
    *	@throws Esier\Exceptions\InvalidConfigurationException
    */
    public function setConfiguration(ConfigurationContainer $configuration)
    {
        if ($configuration->validate()) {
            $this->configuration = $configuration;
        }
    }

    /*
    *	Get configuration for Manager module
    *
    *	@return \StdClass
    */
    public function getManager() : \StdClass
    {
        return $this->configuration->Manager;
    }

    /*
    *	Get configuration for Session module
    *
    *	@return \StdClass
    */
    public function getSession() : \StdClass
    {
        return $this->configuration->Session;
    }

    /*
    *	Get configuration for Cache module
    *
    *	@return \StdClass
    */
    public function getCache() : \StdClass
    {
        return $this->configuration->Cache;
    }

    /*
    *	Get configuration for Log module
    *
    *	@return \StdClass
    */
    public function getLog() : \StdClass
    {
        return $this->configuration->Log;
    }

    /*
    * 	Magic method to access configuration elements
    *
    * 	@param $name
    *
    * 	@return mixed
    */
    public function __get(string $name)
    {
        return $this->configuration->$name;
    }
}

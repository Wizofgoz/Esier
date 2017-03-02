<?php

namespace Esier;

use Esier\Models\CanCallAPIInterface;
use Esier\Models\EndpointFactory;

class Esier
{
    /*
    *	Current version number
    *
    *	@var string
    */
    const VERSION = '0.0.1-alpha';

    /*
    *	Manager object to maintain connection to the API
    *
    *	@var Esier\Manager
    */
    private $manager;

    /*
    *	Array of instanciated endpoints
    *
    *	@var array
    */
    private $endpoints = [];

    /*
    *	Initialize the library
    *
    *	@return void
    */
    public function __construct()
    {
        $this->manager = Manager::getInstance();
    }

    /*
    *	Return array of known scopes
    *
    *	@return array
    */
    public static function getAvailableScopes() : array
    {
        return array_keys(Manager::AVAILABLE_SCOPES);
    }

    /*
    *	Authorizes the connection with the ESI API
    *
    *	@return void
    *
    *	@throws Esier\Exceptions\AuthorizationException
    */
    public function authorize($refresh = null)
    {
        $this->manager->authorize($refresh);
    }

    /*
    *	Return the specified model
    *
    *	@param string $name
    *
    *	@return Esier\Models\CanCallAPIInterface
    *
    *	@throws \InvalidArgumentException
    */
    public function __get(string $name): CanCallAPIInterface
    {
        if (!isset($this->endpoints[$name])) {
            $this->endpoints[$name] = EndpointFactory::factory($name);
        }

        return $this->endpoints[$name];
    }
}

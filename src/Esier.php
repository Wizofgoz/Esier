<?php

namespace Esier;

use Esier\Models\ModelFactory;
use Esier\Models\CanCallAPIInterface;

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
    *	Array of instanciated models
    *
    *	@var array
    */
    private $models = [];

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
        if (!isset($this->models[$name])) {
            $this->models[$name] = ModelFactory::factory($name);
        }

        return $this->models[$name];
    }
	
	/*
	*	Create a new data object of the given type
	*
	*	@param string $type
	*
	*	@return object
	*/
	public function create(string $type)
	{
		return DataFactory::factory($type);
	}
}

<?php

namespace Esier\Models;

class Dogma implements CanCallAPIInterface
{
    use ChecksScopes;
	use ChecksResponses;
	
    /*
    *	Instance of the manager object
    *
    *	@var Esier\Manager
    */
    protected $manager;

    /*
    *	Mapping of scopes required for each function
    *
    *	@var array
    */
    protected $requiredScopes = [
        'attributeIds' => null,
		'attribute' => null,
		'effectIds' => null,
		'effect' => null
    ];

    /*
    *	Construct the model
    *
    *	@return void
    */
    public function __construct()
    {
        $this->manager = Manager::getInstance();
    }
	
	/*
    *	Get a list of dogma attribute ids
    *
    *	@return array
    */
    public function attributeIds(): array
    {
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'dogma/attributes/');

        return $this->checkResponse($response, 200);
    }
	
	/*
    *	Get information on a dogma attribute
    *
    *	@param int $attributeId
    *
    *	@return array
    */
    public function attribute(int $attributeId): array
    {
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'dogma/attributes/'.$attributeId.'/');

        return $this->checkResponse($response, 200);
    }
	
	/*
    *	List all active player alliances
    *
    *	@return array
    */
    public function effectIds(): array
    {
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'dogma/effects/');

        return $this->checkResponse($response, 200);
    }
	
	/*
    *	Get information on a dogma effect
    *
    *	@param int $effectId
    *
    *	@return array
    */
    public function effect(int $effectId): array
    {
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'dogma/effects/'.$effectId.'/');

        return $this->checkResponse($response, 200);
    }
}

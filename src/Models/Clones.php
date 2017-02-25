<?php

namespace Esier\Models;

use Esier\Manager;

class Clones implements CanCallAPIInterface
{
	use ChecksScopes;
	
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
		'clones' => 'clones-read',
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
	*	A list of the character's clones
	*
	*	@param int $characterId
	*
	*	@return array
	*/
	public function clones(integer $characterId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'characters/'.$characterId.'/clones/');
	}
}

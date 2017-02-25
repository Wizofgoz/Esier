<?php

namespace Esier\Models;

use Esier\Manager;

class Alliance implements CanCallAPIInterface
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
		'listIds' => null,
		'names' => null,
		'get' => null,
		'getCorporations' => null,
		'getIcons' => null
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
	*	List all active player alliances
	*
	*	@return array
	*/
	public function listIds(): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'alliances/');
	}
	
	/*
	*	Resolve a set of alliance IDs to alliance names
	*
	*	@param array $allianceIds
	*
	*	@return array
	*/
	public function names(array $allianceIds): array
	{
		$parameters = null;
		if(!empty($allianceIds))
		{
			$parameters = [
				'alliance_ids' => $allianceIds
			];
		}
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'alliances/names/', $parameters);
	}
	
	/*
	*	Public information about an alliance
	*
	*	@param int $allianceId
	*
	*	@return array
	*/
	public function get(integer $allianceId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'alliances/'.$allianceId.'/');
	}
	
	/*
	*	List all current member corporations of an alliance
	*
	*	@param int $allianceId
	*
	*	@return array
	*/
	public function getCorporations(integer $allianceId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'alliances/'.$allianceId.'/corporations/');
	}
	
	/*
	*	Get the icon urls for an alliance
	*
	*	@param int $allianceId
	*
	*	@return array
	*/
	public function getIcons(integer $allianceId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'alliances/'.$allianceId.'/icons');
	}
}

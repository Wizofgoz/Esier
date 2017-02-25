<?php

namespace Esier\Models;

use Esier\Manager;

class Bookmarks implements CanCallAPIInterface
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
		'getBookmarks' => 'bookmarks-read',
		'getFolders' => 'bookmarks-read',
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
	*	List your character's personal bookmarks
	*
	*	@param int $characterId
	*
	*	@return array
	*/
	public function getBookmarks(integer $characterId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'characters/'.$characterId.'/bookmarks/');
	}
	
	/*
	*	List your character's personal bookmark folders
	*
	*	@param int $characterId
	*
	*	@return array
	*/
	public function getFolders(integer $characterId): array
	{
		$this->checkScope(__FUNCTION__);
		
		return $this->manager->call('GET', 'characters/'.$characterId.'/bookmarks/folders/');
	}
}

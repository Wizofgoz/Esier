<?php

namespace Esier\Models;

use Esier\Manager;

class Bookmarks implements CanCallAPIInterface
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
        'get'       => 'bookmarks-read',
        'folders'   => 'bookmarks-read',
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
    public function get(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/bookmarks/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	List your character's personal bookmark folders
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function folders(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/bookmarks/folders/');

        return $this->checkResponse($response, 200);
    }
}

<?php

namespace Esier\Models;

use Esier\Manager;

class Assets implements CanCallAPIInterface
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
        'get' => 'assets-read',
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
    *	Return a list of the characters assets
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function get(integer $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/assets/');

        return $this->checkResponse($response, 200);
    }
}

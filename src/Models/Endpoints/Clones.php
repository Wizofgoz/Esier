<?php

namespace Esier\Models\Endpoints;

use Esier\Manager;

class Clones implements CanCallAPIInterface
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
        'get' => 'clones-read',
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
    public function get(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/clones/');

        return $this->checkResponse($response, 200);
    }
}

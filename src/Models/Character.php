<?php

namespace Esier\Models;

use Esier\Manager;

class Character implements CanCallAPIInterface
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
        'names'       => null,
        'info'        => null,
        'corpHistory' => null,
        'cspa'        => 'contacts-read',
        'portrait'    => null,
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
    *	Resolve a set of character IDs to character names
    *
    *	@param array $characterIds
    *
    *	@return array
    */
    public function names(array $characterIds): array
    {
        $parameters = null;
        if (!empty($characterIds)) {
            $parameters = [
                'character_ids' => $characterIds,
            ];
        }
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/names/', $parameters);

        return $this->checkResponse($response, 200);
    }

    /*
    *	Public information about a character
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function info(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get a list of all the corporations a character has been a member of
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function corpHistory(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/corporationhistory/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Takes a source character ID in the url and a set of target character
    *	ID's in the body, returns a CSPA charge cost
    *
    *	@param int $characterId
    *	@param array $targetIds
    *
    *	@return array
    */
    public function cspa(int $characterId, array $targetIds): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('POST', 'characters/'.$characterId.'/cspa/', null, [
            'characters' => $targetIds,
        ]);

        return $this->checkResponse($response, 201);
    }

    /*
    *	Get portrait urls for a character
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function portrait(int $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/portrait/');

        return $this->checkResponse($response, 200);
    }
}

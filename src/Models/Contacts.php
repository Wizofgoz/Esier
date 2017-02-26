<?php

namespace Esier\Models;

use Esier\Manager;

class Contacts implements CanCallAPIInterface
{
    use ChecksScopes;
    use ChecksResponses;
    use ChecksParameters;

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
        'get'    => 'contacts-read',
        'delete' => 'contacts-write',
        'add'    => 'contacts-write',
        'edit'   => 'contacts-write',
        'labels' => 'contacts-read',
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
    *	Return contacts of a character
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function get(integer $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/contacts/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Bulk delete contacts
    *
    *	@param int $characterId
    *	@param array $targetIds
    *
    *	@return array
    */
    public function delete(integer $characterId, array $targetIds): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('DELETE', 'characters/'.$characterId.'/contacts/', null, [
            'contact_ids' => $targetIds,
        ]);

        return $this->checkResponse($response, 204);
    }

    /*
    *	Bulk add contacts with same settings
    *
    *	@param int $characterId
    *	@param array $targetIds
    *	@param double $standing
    *	@param bool $watch
    *	@param int $labelId
    *
    *	@return array
    */
    public function add(integer $characterId, array $targetIds, double $standing, bool $watch = null, integer $labelId = null): array
    {
        $parameters = [
            'standing' => $standing,
        ];
        $this->addParameter($parameters, 'watched', $watch);
        $this->addParameter($parameters, 'label_id', $labelId);
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('POST', 'characters/'.$characterId.'/contacts/', $parameters, [
            'contact_ids' => $targetIds,
        ]);

        return $this->checkResponse($response, 201);
    }

    /*
    *	Bulk edit contacts with same settings
    *
    *	@param int $characterId
    *	@param array $targetIds
    *	@param double $standing
    *	@param bool $watch
    *	@param int $labelId
    *
    *	@return array
    */
    public function edit(integer $characterId, array $targetIds, double $standing, bool $watch = null, integer $labelId = null): array
    {
        $parameters = [
            'standing' => $standing,
        ];
        $this->addParameter($parameters, 'watched', $watch);
        $this->addParameter($parameters, 'label_id', $labelId);
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('PUT', 'characters/'.$characterId.'/contacts/', $parameters, [
            'contact_ids' => $targetIds,
        ]);

        return $this->checkResponse($response, 204);
    }

    /*
    *	Return custom labels for contacts the character defined
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function labels(integer $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/contacts/labels/');

        return $this->checkResponse($response, 200);
    }
}

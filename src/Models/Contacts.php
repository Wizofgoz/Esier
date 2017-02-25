<?php

namespace Esier\Models;

use Esier\Manager;

class Contacts implements CanCallAPIInterface
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
        'getContacts' => 'contacts-read',
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

        return $this->manager->call('GET', 'characters/'.$characterId.'/contacts/');
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

        return $this->manager->call('DELETE', 'characters/'.$characterId.'/contacts/', null, [
            'contact_ids' => $targetIds,
        ]);
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
        if ($watch !== null) {
            $parameters['watched'] = $watch;
        }
        if ($labelId !== null) {
            $parameters['label_id'] = $labelId;
        }
        $this->checkScope(__FUNCTION__);

        return $this->manager->call('POST', 'characters/'.$characterId.'/contacts/', $parameters, [
            'contact_ids' => $targetIds,
        ]);
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
    public function edit(integer $characterId, array $targetIds, double $standing, bool $watch = null, integer $labelId = null): array
    {
        $parameters = [
            'standing' => $standing,
        ];
        if ($watch !== null) {
            $parameters['watched'] = $watch;
        }
        if ($labelId !== null) {
            $parameters['label_id'] = $labelId;
        }
        $this->checkScope(__FUNCTION__);

        return $this->manager->call('PUT', 'characters/'.$characterId.'/contacts/', $parameters, [
            'contact_ids' => $targetIds,
        ]);
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

        return $this->manager->call('GET', 'characters/'.$characterId.'/contacts/labels/');
    }
}

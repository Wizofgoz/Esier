<?php

namespace Esier\Models\Endpoints;

class Corporation implements CanCallAPIInterface
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
        'names'               => null,
        'listNPCIds'          => null,
        'get'                 => null,
        'allianceHistory'     => null,
        'icons'               => null,
        'members'             => 'corporation-read',
        'roles'               => 'corporation-read',
        'structures'          => 'corporation-structure-read',
        'updateVulnerability' => 'corporation-structure-read',
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
    *	Resolve a set of corporation IDs to corporation names
    *
    *	@param array $corporationIds
    *
    *	@return array
    */
    public function names(array $corporationIds): array
    {
        $parameters = null;
        if (!empty($corporationIds)) {
            $parameters = [
                'alliance_ids' => $corporationIds,
            ];
        }
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/names/', $parameters);

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get a list of npc corporations
    *
    *	@return array
    */
    public function listNPCIds(): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/npccorps/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Public information about a corporation
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function get(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get a list of all the alliances a corporation has been a member of
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function allianceHistory(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/alliancehistory/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get the icon urls for a corporation
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function icons(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/icons/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Read the current list of members if the calling character is a member
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function members(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/members/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Return the roles of all members if the character has the personnel
    *	manager role or any grantable role
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function roles(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/roles/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get a list of corporation structures
    *
    *	@param int $corporationId
    *
    *	@return array
    */
    public function structures(int $corporationId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/structures/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get a list of corporation structures
    *
    *	@param int $corporationId
    *	@param int $structureId
    *	@param int $day
    *	@param int $hour
    *
    *	@return array
    */
    public function updateVulnerability(int $corporationId, int $structureId, int $day, int $hour): array
    {
        if ($day < 0 || $day > 6) {
            throw new InvalidParameterException('Day must be between 0 and 6, 0 being Monday');
        }
        if ($hour < 0 || $hour > 23) {
            throw new InvalidParameterException('Hour must be between 0 and 23, 0 being Midnight');
        }
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'corporations/'.$corporationId.'/structures/'.$structureId.'/', null, [
            'new_schedule' => [
                'day'  => $day,
                'hour' => $hour,
            ],
        ]);

        return $this->checkResponse($response, 204);
    }
}

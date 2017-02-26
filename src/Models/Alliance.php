<?php

namespace Esier\Models;

use Esier\Manager;

class Alliance implements CanCallAPIInterface
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
        'listIds'         => null,
        'names'           => null,
        'get'             => null,
        'corporations'    => null,
        'icons'           => null,
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
        $response = $this->manager->call('GET', 'alliances/');

        return $this->checkResponse($response, 200);
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
        if (!empty($allianceIds)) {
            $parameters = [
                'alliance_ids' => $allianceIds,
            ];
        }
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'alliances/names/', $parameters);

        return $this->checkResponse($response, 200);
    }

    /*
    *	Public information about an alliance
    *
    *	@param int $allianceId
    *
    *	@return array
    */
    public function get(int $allianceId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'alliances/'.$allianceId.'/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	List all current member corporations of an alliance
    *
    *	@param int $allianceId
    *
    *	@return array
    */
    public function corporations(int $allianceId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'alliances/'.$allianceId.'/corporations/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get the icon urls for an alliance
    *
    *	@param int $allianceId
    *
    *	@return array
    */
    public function icons(int $allianceId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'alliances/'.$allianceId.'/icons/');

        return $this->checkResponse($response, 200);
    }
}

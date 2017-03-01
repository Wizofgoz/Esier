<?php

namespace Esier\Models\Endpoints;

class Fittings implements CanCallAPIInterface
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
        'get'        => 'fittings-read',
        'listNPCIds' => null,
        'get'        => null,
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
    *	Return fittings of a character
    *
    *	@param int $characterId
    *
    *	@return array
    */
    public function get(integer $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/fittings/');

        return $this->checkResponse($response, 200);
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
    public function add(integer $characterId, string $name, string $description, int $shipType, array $items): array
    {
        $parameters = [
            'standing' => $standing,
        ];
        $this->addParameter($parameters, 'watched', $watch);
        $this->addParameter($parameters, 'label_id', $labelId);
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('POST', 'characters/'.$characterId.'/fittings/', null, [
            'fitting' => [
                'description'  => $description,
                'items'        => $items,
                'name'         => $name,
                'ship_type_id' => $shipType,
            ],
        ]);

        return $this->checkResponse($response, 201);
    }
}

<?php

namespace Esier\Models;

use Esier\Manager;

class Calendar implements CanCallAPIInterface
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
        'events'      => 'calendar-read',
        'info'  => 'calendar-read',
        'respond' => 'calendar-write',
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
    *	Get 50 event summaries from the calendar. If no event ID is given,
    *	the resource will return the next 50 chronological event summaries
    *	from now. If an event ID is specified, it will return the next 50
    *	chronological event summaries from after that event.
    *
    *	@param int $characterId
    *	@param int $fromEventId
    *
    *	@return array
    */
    public function events(int $characterId, int $fromEventId = null): array
    {
        $parameters = null;
		$this->addParameter($parameters, 'from_event', $fromEventId);
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'characters/'.$characterId.'/calendar/', $parameters);

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get all the information for a specific event
    *
    *	@param int $characterId
    *	@param int $eventId
    *
    *	@return array
    */
    public function info(int $characterId, int $eventId): array
    {
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('GET', 'characters/'.$characterId.'/calendar/'.$eventId.'/');

        return $this->checkResponse($response, 200);
    }

    /*
    *	Get all the information for a specific event
    *
    *	@param int $characterId
    *	@param int $eventId
    *	@param string $response
    *
    *	@return array
    *
    *	@throws InvalidArgumentException
    */
    public function respond(int $characterId, int $eventId, string $response): array
    {
        $availableResponses = [
            'accepted',
            'declined',
            'tentative',
        ];
        if (!in_array($response, $availableResponses)) {
            throw new \InvalidArgumentException('Incorrect value passed for response');
        }
        $this->checkScope(__FUNCTION__);
		$response = $this->manager->call('PUT', 'characters/'.$characterId.'/calendar/'.$eventId.'/', null, [
            'response' => $response,
        ]);

        return $this->checkResponse($response, 204);
    }
}

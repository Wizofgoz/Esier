<?php

namespace Esier\Models;

use Esier\Manager;

class Calendar implements CanCallAPIInterface
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
        'getEvents'      => 'calendar-read',
        'getEventsInfo'  => 'calendar-read',
        'respondToEvent' => 'calendar-write',
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
    public function getEvents(integer $characterId, integer $fromEventId = null): array
    {
        $parameters = null;
        if ($fromEventId !== null) {
            $parameters = [
                'from_event' => $fromEventId,
            ];
        }
        $this->checkScope(__FUNCTION__);

        return $this->manager->call('GET', 'characters/'.$characterId.'/calendar/', $parameters);
    }

    /*
    *	Get all the information for a specific event
    *
    *	@param int $characterId
    *	@param int $eventId
    *
    *	@return array
    */
    public function getEventInfo(integer $characterId, integer $eventId): array
    {
        $this->checkScope(__FUNCTION__);

        return $this->manager->call('GET', 'characters/'.$characterId.'/calendar/'.$eventId.'/');
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
    public function respondToEvent(integer $characterId, integer $eventId, string $response): array
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

        return $this->manager->call('PUT', 'characters/'.$characterId.'/calendar/'.$eventId.'/', null, [
            'response' => $response,
        ]);
    }
}

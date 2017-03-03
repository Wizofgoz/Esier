<?php

namespace Esier\Models\Endpoints;

use Esier\Manager;
use Esier\Models\Data\Contact;
use Esier\Models\Data\ContactList;
use Esier\Models\Data\ContactSettings;

class Contacts implements CanCallAPIInterface
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
    *	@return Esier\Models\Data\ContactList
	*
	*	@throws Esier\Exceptions\ResponseException
    */
    public function get(integer $characterId): ContactList
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/contacts/');
		$contacts = $this->checkResponse($response, 200);
		$list = new ContactList();
		foreach($contacts as $contact)
		{
			$list->addContact(new Contact(
				$contact['contact_id'], 
				$contact['standing'], 
				$contact['is_watched'], 
				$contact['label_id']
			));
		}

        return $list;
    }

    /*
    *	Bulk delete contacts
    *
    *	@param int $characterId
    *	@param Esier\Models\Data\ContactList $contacts
    *
    *	@return bool
	*
	*	@throws Esier\Exceptions\ResponseException
    */
    public function delete(integer $characterId, ContactList $contacts): bool
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('DELETE', 'characters/'.$characterId.'/contacts/', null, [
            'contact_ids' => $contacts->getIds(),
        ]);
		$this->checkResponse($response, 204);

        return true;
    }

    /*
    *	Bulk add contacts with same settings
    *
    *	@param int $characterId
    *	@param Esier\Models\Data\ContactList $contacts
	*	@param Esier\Models\Data\ContactSettings $settings
    *
    *	@return bool
	*
	*	@throws Esier\Exceptions\ResponseException
    */
    public function add(integer $characterId, ContactList $contacts, ContactSettings $settings): bool
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('POST', 'characters/'.$characterId.'/contacts/', $settings->toArray(), [
            'contact_ids' => $contacts->getIds(),
        ]);
		$this->checkResponse($response, 201);

        return true;
    }

    /*
    *	Bulk edit contacts with same settings
    *
    *	@param int $characterId
    *	@param Esier\Models\Data\ContactList $contacts
	*	@param Esier\Models\Data\ContactSettings $settings
    *
    *	@return bool
	*
	*	@throws Esier\Exceptions\ResponseException
    */
    public function edit(integer $characterId, ContactList $contacts, ContactSettings $settings): bool
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('PUT', 'characters/'.$characterId.'/contacts/', $settings->toArray(), [
            'contact_ids' => $contacts->getIds(),
        ]);
		$this->checkResponse($response, 204);

        return true;
    }

    /*
    *	Return custom labels for contacts the character defined
    *
    *	@param int $characterId
    *
    *	@return array
	*
	*	@throws Esier\Exceptions\ResponseException
    */
    public function labels(integer $characterId): array
    {
        $this->checkScope(__FUNCTION__);
        $response = $this->manager->call('GET', 'characters/'.$characterId.'/contacts/labels/');

        return $this->checkResponse($response, 200);
    }
}

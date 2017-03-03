<?php

namespace Esier\Models\Data;

class ContactList implements \Countable, \Iterator
{
    /*
    *	Array of contacts in the list
    *
    *	@var array
    */
    private $contacts = [];

    /*
    *	The index that the pointer is currently at
    *
    *	@var int
    */
    private $currentIndex = 0;

    /*
    *	Adds an item to the list
    *
    *	@param Esier\Models\Data\Contact $item
    *
    *	@return void
    */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /*
    *	Removes a specified contact from the list
    *
    *	@param Esier\Models\Data\Contact $contact
    *
    *	@return void
    */
    public function removeContact(Contact $contactToRemove)
    {
        foreach ($this->contacts as $key => $contact) {
            if ($contact->getId() === $contactToRemove->getId()) {
                unset($this->contacts[$key]);
            }
        }
    }

    /*
    *	Returns count of contacts in the list
    *
    *	@return int
    */
    public function count(): int
    {
        return count($this->contacts);
    }

    /*
    *	Returns Contact at current index
    *
    *	@return Esier\Models\Data\Contact
    */
    public function current(): Contact
    {
        return $this->contacts[$this->currentIndex];
    }

    /*
    *	Returns what index the internal pointer is at
    *
    *	@return int
    */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /*
    *	Moves the internal pointer ahead
    *
    *	@return void
    */
    public function next()
    {
        $this->currentIndex++;
    }

    /*
    *	Resets the internal pointer to 0
    *
    *	@return void
    */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /*
    *	Returns whether the contact at the current index is valid
    *
    *	@return bool
    */
    public function valid(): bool
    {
        return isset($this->contacts[$this->currentIndex]);
    }
	
	/*
	*	Return IDs of all contacts in the list
	*
	*	@return array
	*/
	public function getIds(): array
	{
		$ids = [];
		foreach($this->contacts as $contact)
		{
			$ids[] = $contact->getId();
		}
		return $ids;
	}
}

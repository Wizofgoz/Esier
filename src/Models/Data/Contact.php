<?php

namespace Esier\Models\Data;

class Contact
{
    /*
    *	Unique identifier of the contact from the API
    *
    *	@var int|null
    */
    private $contactId;

    /*
    *	Character's standing towards the contact
    *
    *	@var float
    */
    private $standing;

    /*
    *	Whether the contact is on the character's watch list
    *
    *	@var bool
    */
    private $watched;

    /*
    *	ID of the label to apply to the contact
    *
    *	@var int|null
    */
    private $labelId;

    /*
    *	Initialize object
    *
    *	@param int $contactId
    *	@param float $standing
    *	@param bool $watched
    *	@param int $labelId
    *
    *	@return void
    */
    public function __construct(int $contactId = null, float $standing = 0.0, bool $watched = false, int $labelId = null)
    {
        $this->contactId = $contactId;
        $this->standing = $standing;
        $this->watched = $watched;
        $this->labelId = $labelId;
    }

    /*
    *	Set the standing
    *
    *	@param float $standing
    *
    *	@return void
    */
    public function setStanding(float $standing)
    {
        $this->standing = $standing;
    }

    /*
    *	Set the labelID
    *
    *	@param int $labelId
    *
    *	@return void
    */
    public function setLabel(int $labelId)
    {
        $this->labelId = $labelId;
    }

    /*
    *	Set the watch setting
    *
    *	@param bool $watched
    *
    *	@return void
    */
    public function setWatch(bool $watched)
    {
        $this->watched = $watched;
    }

    /*
    *	Return the Standing
    *
    *	@return float
    */
    public function getStanding(): float
    {
        return $this->standing;
    }

    /*
    *	Return the LabelID
    *
    *	@return int|null
    */
    public function getLabel()
    {
        return $this->labelId;
    }

    /*
    *	Return the Watch status
    *
    *	@return bool
    */
    public function getWatch(): bool
    {
        return $this->watched;
    }

    /*
    *	Return the ID of the contact
    *
    *	@return int|null
    */
    public function getId()
    {
        return $this->contactId;
    }
}

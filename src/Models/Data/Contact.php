<?php

namespace Esier\Models\Data;

class Contact
{
    /*
    *
    *
    *
    */
    private $contactId;

    /*
    *
    *
    *
    */
    private $standing;

    /*
    *
    *
    *
    */
    private $watched;

    /*
    *
    *
    *
    */
    private $labelId;

    /*
    *
    *
    *
    */
    public function __construct(int $contactId, float $standing = 0.0, bool $watched = false, int $labelId = null)
    {
        $this->contactId = $contactId;
        $this->standing = $standing;
        $this->watched = $watched;
        $this->labelId = $labelId;
    }

    /*
    *
    *
    *
    */
    public function setStanding(float $standing)
    {
        $this->standing = $standing;
    }

    /*
    *
    *
    *
    */
    public function setLabel(int $labelId)
    {
        $this->labelId = $labelId;
    }

    /*
    *
    *
    *
    */
    public function setWatch(bool $watched)
    {
        $this->watched = $watched;
    }

    /*
    *
    *
    *
    */
    public function getStanding()
    {
        return $this->standing;
    }

    /*
    *
    *
    *
    */
    public function getLabel()
    {
        return $this->labelId;
    }

    /*
    *
    *
    *
    */
    public function getWatch()
    {
        return $this->watched;
    }
}

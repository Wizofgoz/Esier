<?php

namespace Esier\Models\Data;

class Contact
{
    /*
    *
    *
    *
    */
    private $standing = 0.0;

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
    private $watched = false;

    /*
    *
    *
    *
    */
    public function __construct()
    {
    }

    /*
    *
    *
    *
    */
    public function setStanding(float $standing): self
    {
        $this->standing = $standing;

        return $this;
    }

    /*
    *
    *
    *
    */
    public function setLabel(int $labelId): self
    {
        $this->labelId = $labelId;

        return $this;
    }

    /*
    *
    *
    *
    */
    public function setWatch(bool $watched): self
    {
        $this->watched = $watched;

        return $this;
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

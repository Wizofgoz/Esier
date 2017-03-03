<?php

namespace Esier\Models\Data;

class Fitting
{
    /*
    *	The ID that a fitting is identified by in the API
    *
    *	@var int
    */
    private $fittingId;

    /*
    *	A name given to a fitting to make it easily findable in the client
    *
    *	@var string
    */
    private $name;

    /*
    *	A description to further describe the fitting
    *
    *	@var string
    */
    private $description;

    /*
    *	A list of items that are part of the fitting
    *
    *	@var Esier\Models\Data\ItemList
    */
    private $itemList;

    /*
    *	Instanciate a fitting
    *
    *	@param int $fittingId
    *	@param string $name
    *	@param string $description
    *	@param Esier\Models\Data\ItemList $itemList
    *
    *	@return void
    */
    public function __construct(int $fittingId = null, string $name = '', string $description = '', ItemList $itemList = null)
    {
        $this->fittingId = $fittingId;
        $this->name = $name;
        $this->description = $description;
        $this->itemList = ($itemList === null ? new ItemList() : $itemList);
    }

    /*
    *	Returns the ID for the fitting
    *
    *	@return int|null
    */
    public function getId()
    {
        return $this->fittingId;
    }

    /*
    *	Returns the name of the fitting
    *
    *	@return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    /*
    *	Returns the description of the fitting
    *
    *	@return string
    */
    public function getDescription(): string
    {
        return $this->description;
    }

    /*
    *	Returns the list of items the fitting has
    *
    *	@return Esier\Models\Data\ItemList
    */
    public function getItemList(): ItemList
    {
        return $this->itemList;
    }

    /*
    *	Updates the name of the fitting
    *
    *	@param string $name
    *
    *	@return void
    */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /*
    *	Updates the description of the fitting
    *
    *	@param string $description
    *
    *	@return void
    */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /*
    *	Updates the list of items the fitting has
    *
    *	@param Esier\Models\Data\ItemList $list
    *
    *	@return void
    */
    public function setItemList(ItemList $list)
    {
        $this->itemList = $list;
    }
}

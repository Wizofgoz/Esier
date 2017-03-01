<?php

namespace Esier\Models\Data;

class Item
{
	/*
	*	The ID of the item from Eve Online
	*
	*	@var int
	*/
	private $itemId;
	
	/*
	*	
	*
	*	@var int
	*/
	private $flag;
	
	/*
	*	How many of the given item are to be used
	*
	*	@var int
	*/
	private $quantity;
	
	/*
	*	Initialize the object
	*
	*	@param int $itemId
	*	@param int $quantity
	*	@param int $flag
	*
	*	@return void
	*/
	public function __construct(int $itemId, int $quantity = 1, int $flag = 0)
	{
		$this->itemId = $itemId;
		$this->quantity = $quantity;
		$this->flag = $flag;
	}
	
	/*
	*	Return the ID of the item
	*
	*	@return int
	*/
	public function getId(): int
	{
		return $this->itemId;
	}
	
	/*
	*	Return the flag to use
	*
	*	@return int
	*/
	public function getFlag(): int
	{
		return $this->flag;
	}
	
	/*
	*	Return the number of items to use
	*
	*	@return int
	*/
	public function getQuantity(): int
	{
		return $this->quantity;
	}
	
	/*
	*	Set the flag to use
	*
	*	@param int $flag
	*
	*	@return void
	*/
	public function setFlag(int $flag)
	{
		$this->flag = $flag;
	}
	
	/*
	*	Set the quantity to use
	*
	*	@param int $quantity
	*
	*	@return void
	*/
	public function setQuantity(int $quantity)
	{
		$this->quantity = $quantity;
	}
}
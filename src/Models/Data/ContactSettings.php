<?php

namespace Esier\Models\Data;

class ContactSettings
{
	/*
	*	Standing between -10.0 and 10.0
	*
	*	@var float
	*/
	private $standing;
	
	/*
	*	Whether the contact is on the watch list
	*
	*	@var bool
	*/
	private $watch;
	
	/*
	*	Label id to categorize the Contact under
	*
	*	@var int
	*/
	private $label;
	
	/*
	*	Instanciate the object
	*
	*	@param float $standing
	*	@param bool $watch
	*	@param int $label
	*
	*	@return void
	*/
	public function __construct(float $standing = 0.0, bool $watch = false, int $label = null)
	{
		$this->standing = $standing;
		$this->watch = $watch;
		$this->label = $label;
	}
	
	/*
	*	Return the standing
	*
	*	@return float
	*/
	public function getStanding(): float
	{
		return $this->standing;
	}
	
	/*
	*	Return whether the Contact is on the watch list
	*
	*	@return bool
	*/
	public function getWatched(): bool
	{
		return $this->watch;
	}
	
	/*
	*	Return the label ID the contact is a part of
	*
	*	@return int
	*/
	public function getLabelId(): int
	{
		return $this->label;
	}
	
	/*
	*	Return settings in associative array
	*
	*	@return array
	*/
	public function toArray(): array
	{
		$arr = [
			'standing' => $this->standing,
			'watched' => $this->watch
		];
		if($this->label !== null){
			$arr['label_id'] = $this->label;
		}
		
		return $arr;
	}
}
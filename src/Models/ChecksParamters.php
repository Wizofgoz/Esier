<?php

namespace Esier\Models;

trait ChecksParameters
{
	/*
	*	Checks that a parameter should be added to the given array and adds it
	*
	*	@param &array $array
	*	@param string $key
	*	@param mixed $value
	*
	*	@return void
	*/
	private function addParameter(array &$array, string $key, $value)
	{
		if($value !== null)
		{
			$array[$key] = $value;
		}
	}
}
<?php

namespace Esier\Manager\Session;

class ArraySession implements CanStoreInterface
{
	/*
	*	Array for storing data
	*
	*	@var array
	*/
	private $data = [];
	
	/*
	*	Configuration for the session
	*
	*	@var array
	*/
	private $config;
	
	/*
	*	Initialize the object
	*
	*	@param array $config
	*
	*	@return void
	*/
	public function __construct(array $config = [])
	{
	}

	/*
	*	Start the session (does nothing)
	*
	*	@return boolean
	*/
    public function startSession()
	{
		return true;
	}

	/*
	*	Store value in array
	*
	*	@param string $name
	*	@param mixed $value
	*
	*	@return void
	*/
    public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	/*
	*	Get a value from array
	*
	*	@param string $name
	*
	*	@return mixed
	*/
    public function __get($name)
	{
		return $this->data[$name];
	}

	/*
	*	Checks if a value is stored in array
	*
	*	@param string $name
	*
	*	@return boolean
	*/
    public function __isset($name)
	{
		isset($this->data[$name]);
	}

	/*
	*	Clears a value from the array
	*
	*	@param string $name
	*
	*	@return void
	*/
    public function __unset($name)
	{
		unset($this->data[$name]);
	}

	/*
	*	Clears all data from array
	*
	*	@return void
	*/
    public function destroy()
	{
		$this->data = [];
	}
}

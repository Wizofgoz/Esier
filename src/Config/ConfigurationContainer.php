<?php
namespace Esier\Config;

use Esier\Exceptions\InvalidConfigurationException;

class ConfigurationContainer
{
	/*
	*	Elements of configuration that must have values
	*
	*	@var array
	*/
	protected $requiredConfiguration = [
		'Manager' => [
			'client_id',
			'secret_key',
			'callback_url'
		],
		'Log' => [
			'handler'
		],
		'Cache' => [
			'handler'
		],
		'Session' => [
			'handler'
		]
	];
	
	/*
	*	Current configuration
	*
	*	@var array
	*/
	protected $configuration = [];
	
	/*
	*	Container constructor
	*
	*	@param array $configuration
	*
	*	@return void
	*/
	public function __construct(array $configuration)
	{
		foreach($configuration as $key => $value)
		{
			$this->configuration[$key] = (object) $value;
		}
	}
	
	/*
	*	Validate the current configuration
	*
	*
	*/
	public function validate() : bool
	{
		foreach($this->requiredConfiguration as $setting)
		{
			if(isset($configuration[$setting]))
			{
				foreach($setting as $option)
				{
					if(isset($configuration[$setting][$option]))
						continue;
					throw new InvalidConfigurationException($setting.' => '.$option.' has an invalid value');
				}
				continue;
			}
			throw new InvalidConfigurationException($setting.' has an invalid value');
		}
		return true;
	}
	
	/*
	*	Retrieve properties from configuration array
	*
	*	@param string $name
	*
	*	@return mixed
	*/
	public function __get(string $name)
	{
		return $this->configuration[$name];
	}
}

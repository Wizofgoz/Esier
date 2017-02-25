<?php

namespace Esier\Http;

use GuzzleHttp\Client;

class GuzzleHttp
{
	/*
	*	Client instance
	*
	*	@var GuzzleHttp\Client
	*/
	private $client;
	
	/*
	*	Create the object
	*
	*	@param array $config
	*
	*	@return void
	*/
	public function __construct(array $config)
	{
		$this->client = new Client($config);
	}
	
	/*
	*	Handle a request with the client
	*
	*	@param string $method
	*	@param string $uri
	*	@param array $settings
	*
	*	@return array
	*/
	public function request(string $method, string $uri, array $settings) : array
	{
		$response = $this->client->request($method, $uri, $settings);
		if((string)$response->getBody() != '')
		{
			return \json_decode((string) $response->getBody(), true);
		}
		return \json_decode((string) $response->getHeaders(), true);
	}
}
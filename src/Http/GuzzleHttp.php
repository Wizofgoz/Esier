<?php

namespace Esier\Http;

use GuzzleHttp\Client;

class GuzzleHttp implements HttpInterface
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
    *	@return Esier\Http\APIResponse
    */
    public function request(string $method, string $uri, array $settings) : APIResponse
    {
        $response = $this->client->request($method, $uri, $settings);

        return new APIResponse(
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            $response->getHeaders(),
            (string) $response->getBody()
        );
    }
}

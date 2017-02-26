<?php

namespace Esier\Models;

use Esier\Exceptions\ResponseException;
use Esier\Http\APIResponse;

trait ChecksResponses
{
    /*
    *	Checks that the response didn't return an error
    *
    *	@param Esier\Http\APIResponse $response
    *	@param integer $expectedStatusCode
    *
    *	@return array
    *
    *	@throws Esier\Exceptions\ResponseException
    */
    public function checkResponse(APIResponse $response, int $expectedStatusCode): array
    {
        if ($response->statusCode !== $expectedStatusCode) {
            $body = json_decode($response->getBody());
            throw new ResponseException('API Error: '.$body['error'], $response->getStatusCode());
        }

        return json_decode($response->getBody(), true);
    }
}

<?php

namespace Esier\Http;

class NullHttp implements HttpInterface
{
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
        return new APIResponse(200, 'Success', [], '');
    }
}

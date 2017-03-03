<?php

namespace Esier\Http;

class APIResponse
{
    /*
    *	Response status code
    *
    *	@var int
    */
    private $statusCode = 0;

    /*
    *	Response Reason Phrase
    *
    *	@var string
    */
    private $reasonPhrase = '';

    /*
    *	Response headers
    *
    *	@var array
    */
    private $headers = [];

    /*
    *	Mapping of header keys to known case
    *
    *	@var array
    */
    private $headersMap = [];

    /*
    *	Response body
    *
    *	@var string
    */
    private $body = '';

    /*
    *	Instanciate the object
    *
    *	@param int $statusCode
    *	@param string $reasonPhrase
    *	@param array $headers
    *	@param string $body
    *
    *	@return void
    */
    public function __construct(integer $statusCode, string $reasonPhrase, array $headers, string $body)
    {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->headers = $headers;
        $keys = \array_keys($headers);
        foreach ($keys as $key) {
            $this->headersMap[strtolower($key)] = $key;
        }
    }

    /*
    *	Get a header as a string, if multiple values they are concatenated with
    *	a comma
    *
    *	@param string $name
    *
    *	@return string
    */
    public function getHeaderLine(string $name): string
    {
        return \implode(',', $this->headers[$this->headersMap[\strtolower($name)]]);
    }

    /*
    *	Get a header as an array
    *
    *	@param string $name
    *
    *	@return array
    */
    public function getHeader(string $name): array
    {
        return $this->headers[$this->headersMap[\strtolower($name)]];
    }

    /*
    *	Checks if a header exists
    *
    *	@param string $name
    *
    *	@return boolean
    */
    public function hasHeader(string $name): bool
    {
        return \in_array(\strtolower($name), $this->headersMap);
    }

    /*
    *	Get all headers as an array
    *
    *	@return array
    */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /*
    *	Get the response status code
    *
    *	@return int
    */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /*
    *	Get the reason phrase associated with the status code
    *
    *	@return string
    */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /*
    *	Get the reason phrase associated with the status code
    *
    *	@return string
    */
    public function getBody(): string
    {
        return $this->body;
    }
}

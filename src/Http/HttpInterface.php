<?php

namespace Esier\Http;

interface HttpInterface
{
	public function request(string $method, string $uri, array $settings) : APIResponse;
}
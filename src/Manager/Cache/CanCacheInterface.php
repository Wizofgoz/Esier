<?php

namespace Esier\Manager\Cache;

interface CanCacheInterface
{
	public function set($uri, $key, $data);
	
	public function get($uri, $key);
	
	public function forget($uri, $key);
	
	public function has($uri, $key);
}

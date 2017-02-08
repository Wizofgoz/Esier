<?php

namespace Esier\Manager\Cache;

class NullCache implements CanCacheInterface
{
    /*
    *	Set data into cache
    *
    *	@param string $uri
    *	@param string $key
    *	@param array $data
    *
    *	@return mixed|void
    */
    public function set($uri, $key, $data)
    {
    }

    /*
    *	Get data from cache
    *
    *	@param string $uri
    *	@param string $key
    *
    *	@return mixed
    */
    public function get($uri, $key)
    {
        return false;
    }

    /*
    *	Remove data from cache
    *
    *	@param string $uri
    *	@param string $key
    *
    *	@return mixed
    */
    public function forget($uri, $key)
    {
    }

    /*
    *	Check if there is data in cache
    *
    *	@param string $uri
    *	@param string $key
    *
    *	@return mixed
    */
    public function has($uri, $key)
    {
        return false;
    }
}

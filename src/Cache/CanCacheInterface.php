<?php

namespace Esier\Cache;

interface CanCacheInterface
{
    public function set(string $uri, string $key, $data);

    public function get(string $uri, string $key);

    public function forget(string $uri, string $key);

    public function has(string $uri, string $key);
}

<?php

namespace Esier\Manager\Session;

interface CanStoreInterface
{
    public function __construct($name, $limit = 0, $path = '/', $domain = null, $secure = null);

    public function startSession();

    public function __set($name, $value);

    public function __get($name);

    public function __isset($name);

    public function __unset($name);

    public function destroy();
}

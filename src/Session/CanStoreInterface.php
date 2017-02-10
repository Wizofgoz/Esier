<?php

namespace Esier\Session;

interface CanStoreInterface
{
    public function __construct(array $config);

    public function startSession() : bool;

    public function __set(string $name, $value);

    public function __get(string $name);

    public function __isset(string $name) : bool;

    public function __unset(string $name);

    public function destroy() : bool;
}

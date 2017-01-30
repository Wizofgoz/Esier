<?php
namespace Esir\Manager\Session;
interface CanStoreInterface
{
	public function __get($name);
	public function __set($name, $value);
}
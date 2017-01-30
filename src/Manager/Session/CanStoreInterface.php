<?php
namespace Esir\Manager\Session;
interface CanStoreInterface
{
	public function __construct($name, $limit = 0, $path = '/', $domain = NULL, $secure = NULL);
	public function startSession();
	public function __set( $name , $value );
	public function __get( $name );
	public function __isset( $name );
	public function __unset( $name );
	public function destroy();
}

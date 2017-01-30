<?php
namespace Esir\Core;
use \Esir\Core\Manager;
interface CanCallAPIInterface
{
	public function __construct(Manager $manager, array $args);
	private function call();
}
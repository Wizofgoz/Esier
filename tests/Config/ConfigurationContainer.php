<?php

namespace Tests\Config;

use PHPUnit\Framework\TestCase;

class ConfigurationContainer extends TestCase
{
	public function testEmptyConfiguration()
	{
		$container = new \Esier\Config\ConfigurationContainer([]);
		$this->expectException(\Esier\Exceptions\InvalidConfigurationException::class);
	}
}

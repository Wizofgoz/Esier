<?php

namespace Tests\Config;

use PHPUnit\Framework\TestCase;

class ConfigurationManager extends TestCase
{
    public function testSingleton()
    {
        $this->assertInstanceOf(\Esier\Config\ConfigurationManager::class, \Esier\Config\ConfigurationManager::getInstance());
    }
}

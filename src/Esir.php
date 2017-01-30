<?php
namespace Esir;
use \GuzzleHttp\Client;
use \Esir\Manager\Manager;
class Esir
{
	private $version = '0.0.1-alpha';
	
	private $classmap = array(
		'Alliance' => \Esir\Core\Alliance::class,
		'Assets' => \Esir\Core\Assets::class,
		'Bookmarks' => \Esir\Core\Bookmarks::class,
		'Calendar' => \Esir\Core\Calendar::class,
		'Character' => \Esir\Core\Character::class,
		'Clones' => \Esir\Core\Clones::class,
		'Contracts' => \Esir\Core\Contracts::class,
		'Corporation' => \Esir\Core\Corporation::class,
		'Fittings' => \Esir\Core\Fittings::class,
		'Fleet' => \Esir\Core\Fleet::class,
		'Incursions' => \Esir\Core\Incursions::class,
		'Industry' => \Esir\Core\Industry::class,
		'Insurance' => \Esir\Core\Insurance::class,
		'KillMails' => \Esir\Core\KillMails::class,
		'Location' => \Esir\Core\Location::class,
		'Market' => \Esir\Core\Market::class,
		'PlanetaryInteraction' => \Esir\Core\PlanetaryInteraction::class,
		'Search' => \Esir\Core\Search::class,
		'Skills' => \Esir\Core\Skills::class,
		'Sovereignty' => \Esir\Core\Sovereignty::class,
		'Universe' => \Esir\Core\Universe::class,
		'UserInterface' => \Esir\Core\UserInterface::class,
		'Wallet' => \Esir\Core\Wallet::class,
		'Wars' => \Esir\Core\Wars::class
	);
	
	private $aliases = array(
		'Char' => 'Character',
		'Corp' => 'Corporation',
		'KM' => 'KillMails',
		'PI' => 'PlanetaryInteraction',
		'Sov' => 'Sovereignty',
		'UI' => 'UserInterface'
	);
	
	private $config;
	
	private $manager;
	
	public function __construct()
	{
		$this->config = require_once(__DIR__.'/Config.php');
		$this->manager = new Manager($this->config);
	}
	
	/*
	*	Transfers all calls to the appropriate classes
	*
	*
	*/
	public function __call($name, $arguments)
	{
		//	Check aliases first to get actual name
		$name = (in_array($name, $this->aliases) ? $this->aliases[$name] : $name);
		if(!isset($this->classmap[$name]))
			throw new Exception;
		return new $name($this->manager, $arguments);
	}
}
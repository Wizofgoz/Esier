<?php

namespace Esier;

use Esier\Manager\Manager;

class Esir
{
    private $version = '0.0.1-alpha';

    private $classmap = [
        'Alliance'             => \Esier\Core\Alliance::class,
        'Assets'               => \Esier\Core\Assets::class,
        'Bookmarks'            => \Esier\Core\Bookmarks::class,
        'Calendar'             => \Esier\Core\Calendar::class,
        'Character'            => \Esier\Core\Character::class,
        'Clones'               => \Esier\Core\Clones::class,
        'Contracts'            => \Esier\Core\Contracts::class,
        'Corporation'          => \Esier\Core\Corporation::class,
        'Fittings'             => \Esier\Core\Fittings::class,
        'Fleet'                => \Esier\Core\Fleet::class,
        'Incursions'           => \Esier\Core\Incursions::class,
        'Industry'             => \Esier\Core\Industry::class,
        'Insurance'            => \Esier\Core\Insurance::class,
        'KillMails'            => \Esier\Core\KillMails::class,
        'Location'             => \Esier\Core\Location::class,
        'Market'               => \Esier\Core\Market::class,
        'PlanetaryInteraction' => \Esier\Core\PlanetaryInteraction::class,
        'Search'               => \Esier\Core\Search::class,
        'Skills'               => \Esier\Core\Skills::class,
        'Sovereignty'          => \Esier\Core\Sovereignty::class,
        'Universe'             => \Esier\Core\Universe::class,
        'UserInterface'        => \Esier\Core\UserInterface::class,
        'Wallet'               => \Esier\Core\Wallet::class,
        'Wars'                 => \Esier\Core\Wars::class,
    ];

    private $aliases = [
        'Char' => 'Character',
        'Corp' => 'Corporation',
        'KM'   => 'KillMails',
        'PI'   => 'PlanetaryInteraction',
        'Sov'  => 'Sovereignty',
        'UI'   => 'UserInterface',
    ];

    private $config;

    private $manager;

    public function __construct()
    {
        $this->config = require_once __DIR__.'/Config.php';
        $this->manager = new Manager($this->config);
    }

    public function getVersion()
    {
        return $this->version;
    }

    public static function getAvailableScopes()
    {
        return array_keys(Manager::AVAILABLE_SCOPES);
    }

    /*
    *	Authorizes the connection with the ESI API
    *
    *
    */
    public function authorize($refresh = null)
    {
        $this->manager->authorize($refresh);
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
        if (!isset($this->classmap[$name])) {
            throw new Exception();
        }

        return new $name($this->manager, $arguments);
    }
}

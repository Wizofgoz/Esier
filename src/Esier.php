<?php

namespace Esier;

class Esier
{
    /*
    *	Current version number
    *
    *	@var string
    */
    const VERSION = '0.0.1-alpha';

    /*
    *	Mapping of class names to fully-qualified versions for easy calling
    *
    *	@var array
    */
    private $classmap = [
        'Alliance'             => \Esier\Models\Alliance::class,
        'Assets'               => \Esier\Models\Assets::class,
        'Bookmarks'            => \Esier\Models\Bookmarks::class,
        'Calendar'             => \Esier\Models\Calendar::class,
        'Character'            => \Esier\Models\Character::class,
        'Clones'               => \Esier\Models\Clones::class,
        'Contracts'            => \Esier\Models\Contracts::class,
        'Corporation'          => \Esier\Models\Corporation::class,
        'Fittings'             => \Esier\Models\Fittings::class,
        'Fleet'                => \Esier\Models\Fleet::class,
        'Incursions'           => \Esier\Models\Incursions::class,
        'Industry'             => \Esier\Models\Industry::class,
        'Insurance'            => \Esier\Models\Insurance::class,
        'KillMails'            => \Esier\Models\KillMails::class,
        'Location'             => \Esier\Models\Location::class,
        'Market'               => \Esier\Models\Market::class,
        'PlanetaryInteraction' => \Esier\Models\PlanetaryInteraction::class,
        'Search'               => \Esier\Models\Search::class,
        'Skills'               => \Esier\Models\Skills::class,
        'Sovereignty'          => \Esier\Models\Sovereignty::class,
        'Universe'             => \Esier\Models\Universe::class,
        'UserInterface'        => \Esier\Models\UserInterface::class,
        'Wallet'               => \Esier\Models\Wallet::class,
        'Wars'                 => \Esier\Models\Wars::class,
    ];

    /*
    *	Mapping of aliases of classes for shorthand
    *
    *	@var array
    */
    private $aliases = [
        'Char' => 'Character',
        'Corp' => 'Corporation',
        'KM'   => 'KillMails',
        'PI'   => 'PlanetaryInteraction',
        'Sov'  => 'Sovereignty',
        'UI'   => 'UserInterface',
    ];

    /*
    *	Manager object to maintain connection to the API
    *
    *	@var Esier\Manager
    */
    private $manager;

    /*
    *	Initialize the library
    *
    *	@return void
    */
    public function __construct()
    {
        $this->manager = Manager::getInstance();
    }

    /*
    *	Return array of known scopes
    *
    *	@return array
    */
    public static function getAvailableScopes() : array
    {
        return array_keys(Manager::AVAILABLE_SCOPES);
    }

    /*
    *	Authorizes the connection with the ESI API
    *
    *	@return void
    *
    *	@throws Esier\Exceptions\AuthorizationException
    */
    public function authorize($refresh = null)
    {
        $this->manager->authorize($refresh);
    }

    /*
    *	Transfers all calls to the appropriate classes
    *
    *	@param string $name
    *	@param array $arguments
    *
    *	@return Esier\Core\CanCallAPIInterface
    *
    *	@throws Esier\Exceptions\UnknownScopeException
    */
    public function __call($name, $arguments)
    {
        //	Check aliases first to get actual name
        $name = (in_array($name, $this->aliases) ? $this->aliases[$name] : $name);
        if (!isset($this->classmap[$name])) {
            throw new UnknownScopeException($name.' is not a valid scope');
        }

        return new $this->classmap[$name]($this->manager, $arguments);
    }
}

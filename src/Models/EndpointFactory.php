<?php

namespace Esier\Models;

final class EndpointFactory
{
    /*
    *	Mapping of aliases of classes for shorthand
    *
    *	@var array
    */
    const ALIASES = [
        'Char' => 'Character',
        'Corp' => 'Corporation',
        'KM'   => 'KillMails',
        'PI'   => 'PlanetaryInteraction',
        'Sov'  => 'Sovereignty',
        'UI'   => 'UserInterface',
    ];

    /*
    *	Mapping of classes to full class names
    *
    *	@var array
    */
    const MODELS = [
        'Alliance'             => \Esier\Models\Endpoints\Alliance::class,
        'Assets'               => \Esier\Models\Endpoints\Assets::class,
        'Bookmarks'            => \Esier\Models\Endpoints\Bookmarks::class,
        'Calendar'             => \Esier\Models\Endpoints\Calendar::class,
        'Character'            => \Esier\Models\Endpoints\Character::class,
        'Clones'               => \Esier\Models\Endpoints\Clones::class,
        'Contacts'             => \Esier\Models\Endpoints\Contacts::class,
        'Corporation'          => \Esier\Models\Endpoints\Corporation::class,
        'Dogma'                => \Esier\Models\Endpoints\Dogma::class,
        'Fittings'             => \Esier\Models\Endpoints\Fittings::class,
        'Fleet'                => \Esier\Models\Endpoints\Fleet::class,
        'Incursions'           => \Esier\Models\Endpoints\Incursions::class,
        'Industry'             => \Esier\Models\Endpoints\Industry::class,
        'Insurance'            => \Esier\Models\Endpoints\Insurance::class,
        'KillMails'            => \Esier\Models\Endpoints\KillMails::class,
        'Location'             => \Esier\Models\Endpoints\Location::class,
        'Market'               => \Esier\Models\Endpoints\Market::class,
        'PlanetaryInteraction' => \Esier\Models\Endpoints\PlanetaryInteraction::class,
        'Search'               => \Esier\Models\Endpoints\Search::class,
        'Skills'               => \Esier\Models\Endpoints\Skills::class,
        'Sovereignty'          => \Esier\Models\Endpoints\Sovereignty::class,
        'Universe'             => \Esier\Models\Endpoints\Universe::class,
        'UserInterface'        => \Esier\Models\Endpoints\UserInterface::class,
        'Wallet'               => \Esier\Models\Endpoints\Wallet::class,
        'Wars'                 => \Esier\Models\Endpoints\Wars::class,
    ];

    /*
    *	Resolve alias if given and return full name
    *
    *	@param string $type
    *
    *	@return string
    */
    private static function resolveAlias(string $type): string
    {
        return in_array($type, self::ALIASES) ? self::ALIASES[$type] : $type;
    }

    /*
    *	Factory Method
    *
    *	@param string $type
    *
    *	@return Esier\Models\CanCallAPIInterface
    *
    *	@throws \InvalidArgumentException
    */
    public static function factory(string $type): CanCallAPIInterface
    {
        $name = self::resolveAlias($type);
        if (!in_array($name, array_keys(self::MODELS))) {
            throw new \InvalidArgumentException('Unknown model type given');
        }
        $class = self::MODELS[$name];

        return new $class();
    }
}

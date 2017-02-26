<?php

namespace Esier\Models;

final class ModelFactory
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
        switch ($name) {
            case 'Alliance':
                return new Alliance();
                break;
            case 'Assets':
                return new Assets();
                break;
            case 'Bookmarks':
                return new Bookmarks();
                break;
            case 'Calendar':
                return new Calendar();
                break;
            case 'Character':
                return new Character();
                break;
            case 'Clones':
                return new Clones();
                break;
            case 'Contacts':
                return new Contacts();
                break;
            case 'Corporation':
                return new Corporation();
                break;
			case 'Dogma':
                return new Dogma();
                break;
            case 'Fittings':
                return new Fittings();
                break;
            case 'Fleet':
                return new Fleet();
                break;
            case 'Incursions':
                return new Incursions();
                break;
            case 'Industry':
                return new Industry();
                break;
            case 'Insurance':
                return new Insurance();
                break;
            case 'KillMails':
                return new KillMails();
                break;
            case 'Location':
                return new Location();
                break;
            case 'Market':
                return new Market();
                break;
            case 'PlanetaryInteraction':
                return new PlanetaryInteraction();
                break;
            case 'Search':
                return new Search();
                break;
            case 'Skills':
                return new Skills();
                break;
            case 'Sovereignty':
                return new Sovereignty();
                break;
            case 'Universe':
                return new Universe();
                break;
            case 'UserInterface':
                return new UserInterface();
                break;
            case 'Wallet':
                return new Wallet();
                break;
            case 'Wars':
                return new Wars();
                break;
            default:
                throw new \InvalidArgumentException('Unknown model type given');
        }
    }
}

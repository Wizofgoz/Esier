<?php

namespace Esier\Models\Data;

final class DataFactory
{
    public static function factory(string $type)
    {
        switch ($type) {
            case 'Contact':
                return new Contact();
                break;
            case 'Fitting':
                return new Fitting();
                break;
            case 'Item':
                return new Item();
                break;
            default:
                throw new \InvalidArgumentException('Unknown model type given');
        }
    }
}

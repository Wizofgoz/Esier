<?php
namespace Esir\Core;
use \Esir\Exceptions\MemberAccessException;
use \Esir\Core\CanCallAPIInterface;
abstract class Base implements CanCallAPIInterface
{
	protected function checkArguments(array $args, $min, $max, $methodName) {
        $argc = count($args);
        if ($argc < $min || $argc > $max) {
            throw new MemberAccessException('Method ' . $methodName . ' needs minimaly ' . $min . ' and maximaly ' . $max . ' arguments. ' . $argc . ' arguments given.');
        }
    }
}
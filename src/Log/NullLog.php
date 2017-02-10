<?php

namespace Esier\Log;

class NullLog implements CanLogInterface
{
    /*
    *	Adds data to the normal log
    *
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function log(string $message)
    {
    }

    /*
    *	Adds data to the debug log
    *
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function debug(string $message)
    {
    }

    /*
    *	Adds data to the warning log
    *
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function warning(string $message)
    {
    }

    /*
    *	Adds data to the error log
    *
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function error(string $message)
    {
    }
}

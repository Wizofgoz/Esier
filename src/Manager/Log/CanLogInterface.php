<?php

namespace Esier\Manager\Log;

interface CanLogInterface
{
	/*
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function log(string $message);
	
    /*
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function debug(string $message);
	
    /*
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function warning(string $message);
	
    /*
    * 	@param string $message
    *
    * 	@return mixed
    */
    public function error(string $message);
}

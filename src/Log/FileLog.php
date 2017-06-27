<?php

namespace Esier\Log;

class FileLog implements CanLogInterface
{
	/*
	*	Path to the folder where logs will be stored
	*
	*	@var string
	*/
	protected $location;
	
	/*
	*	What rotation configuration to use
	*
	*	@var string
	*/
	protected $rotation;
	
	/*
	*	File handle resource for adding to the log
	*
	*	@var resource
	*/
	protected $handle;
	
	/*
	*	DateTime when the handle was opened
	*
	*	@var \DateTime
	*/
	protected $timeOpened;
	
	/*
	*	Initialize the object
	*
	*	@param array $config
	*
	*	@return void
	*/
	public function __construct(array $config)
	{
		$this->location = $config['location'];
		$this->rotation = $config['rotation'];
	}
	
	/*
	*	Log message with specified log level
	*
	*	@param string $level
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function log($level, $message, array $context = array())
	{
		$logMessage = "{log_level} [{log_date}]: {$message}";
		$context['log_level'] = strtoupper($level);
		$context['log_date'] = date('Y-m-d H:i:s');
		fwrite($this->getHandle(), $this->interpolate($logMessage, $context));
	}
	
	/*
	*	Log message with debug log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function debug($message, array $context = array())
	{
		$this->log(LogLevel::DEBUG, $message, $context);
	}
	
	/*
	*	Log message with info log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function info($message, array $context = array())
	{
		$this->log(LogLevel::INFO, $message, $context);
	}
	
	/*
	*	Log message with notice log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function notice($message, array $context = array())
	{
		$this->log(LogLevel::NOTICE, $message, $context);
	}
	
	/*
	*	Log message with warning log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function warning($message, array $context = array())
	{
		$this->log(LogLevel::WARNING, $message, $context);
	}
	
	/*
	*	Log message with error log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function error($message, array $context = array())
	{
		$this->log(LogLevel::ERROR, $message, $context);
	}
	
	/*
	*	Log message with critical log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function critical($message, array $context = array())
	{
		$this->log(LogLevel::CRITICAL, $message, $context);
	}
	
	/*
	*	Log message with alert log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function alert($message, array $context = array())
	{
		$this->log(LogLevel::ALERT, $message, $context);
	}
	
	/*
	*	Log message with emergency log level
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return void
	*/
	public function emergency($message, array $context = array())
	{
		$this->log(LogLevel::EMERGENCY, $message, $context);
	}
	
	/*
	* 	Interpolates context values into the message placeholders.
	*
	*	@param string $message
	*	@param array $context
	*
	*	@return string
	*/
	function interpolate($message, array $context = array())
	{
		// build a replacement array with braces around the context keys
		$replace = array();
		foreach ($context as $key => $val) {
			// check that the value can be casted to string
			if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
				$replace['{' . $key . '}'] = $val;
			}
		}

		// interpolate replacement values into the message and return
		return strtr($message, $replace);
	}
	
	/*
	*	Get the current file handle
	*
	*	@return resource
	*/
	public function getHandle()
	{
		if (is_null($this->handle)) {
			return $this->openFile($this->getFileName());
		}
		
		if ($this->isRotatible()) {
			fclose($this->handle);
			return $this->openFile($this->getFileName());
		}
		
		return $this->handle;
	}
	
	/*
	*	Determine if the log file needs to be rotated
	*
	*	@return bool
	*/
	protected function isRotatible()
	{
		switch ($this->rotation) {
			case 'daily':
				return $this->timeOpened->format('d') != (new \DateTime)->format('d');
			case 'monthly':
				return $this->timeOpened->format('m') != (new \DateTime)->format('m');
			default:
				return false;
		}
	}
	
	/*
	*	Build the current path with file name for the log
	*
	*	@return string
	*/
	protected function getFileName()
	{
		switch ($this->rotation) {
			case 'daily':
				$file = $this->location.date('Y-m-d').'.txt';
				break;
			case 'monthly':
				$file = $this->location.date('M-Y').'.txt';
				break;
			default:
				$file = $this->location.date('log').'.txt';
		}
		
		return $file;
	}
	
	/*
	*	Open a file handle at the given path and set the time
	*
	*	@param string $path
	*
	*	@return resource
	*/
	protected function openFile($path)
	{
		$this->timeOpened = new \DateTime();
		return $this->handle = fopen($path, 'a');
	}
	
	/*
	*	Close the file handle when the object is destroyed
	*
	*	@return void
	*/
	public function __destruct()
	{
		fclose($this->handle);
	}
}

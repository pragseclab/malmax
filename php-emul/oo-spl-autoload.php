<?php

namespace PHPEmul;

use PhpParser\Node;


trait OOEmulator_spl_autoload 
{
	protected $autoloaders=[];
	public function spl_autoload_register($callback=null, $throw=true, $prepend=false)
	{
		if ($callback===null)
			$callback="spl_autoload"; //default autoloader of php
		if ($prepend)
			array_unshift($this->autoloaders, $callback);
		else
			$this->autoloaders[]=$callback;
		return true;
	}
	public function spl_autoload_unregister($callback)
	{
		if ( ($key=array_search($callback, $this->autoloaders))!==false)
		{
			unset($this->autoloaders[$key]);
			return true;
		}
		return false;

	}
	public function spl_autoload_functions()
	{
		return $this->autoloaders;
	}
	public function spl_autoload_call(&$class)
	{
        $result = null;
		if (empty($this->autoloaders)) return $result;
		$this->verbose("Attempting to autoload '{$class}'...\n",3);
		foreach ($this->autoloaders as $autoloader)
			// if ($this->class_exists($class))
            if ($this->user_class_exists($class, true))
			    break;
			else 
			{
				$this->verbose("Calling the next autoloader to autoload '{$class}'...\n",4);
				$result = $this->call_function($autoloader,[$class]);
			}	
		$this->verbose("Autoloading '{$class}' completed.\n",3);
        return $result;
	}
	protected $autoload_extensions=".inc,.php";
	public function spl_autoload_extensions($extensions=null)
	{
		if ($extensions===null) return $this->autoload_extensions;
		spl_autoload_extensions($extensions);
		$this->autoload_extensions=$extensions;
	}
	function autoload($class)
	{
		return $this->spl_autoload_call($class);
	}
}
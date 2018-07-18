<?php 

namespace app\controllers;

use Interop\Container\ContainerInterface;

class controller 
{
	protected $c;
	
	function __construct(ContainerInterface $container)
	{
		$this->c = $container;

	}
}
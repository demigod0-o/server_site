<?php 

namespace app\controllers;

use Interop\Container\ContainerInterface;

class controller 
{
	protected $c;

	public $response_message;
	
	function __construct(ContainerInterface $container)
	{
		$this->c = $container;

	}


	function jsonResponse(){
	
	}
}
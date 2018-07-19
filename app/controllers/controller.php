<?php 

namespace app\controllers;

use Interop\Container\ContainerInterface;

class controller 
{
	protected $c;

	protected $response_message;

	protected $status_code;
	
	function __construct(ContainerInterface $container)
	{
		$this->c = $container;
	}
}
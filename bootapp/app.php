<?php 	
	use PDO;
	$app = new \Slim\App([

		'settings' => [

			'displayErrorDetails' => true

		]

	]);

	$container = $app->getContainer();

	$container['db'] = function (){

		return new PDO(
			'mysql:dbname=billing_server;host=127.0.0.1',
			'root',
			'toor'
		);
	};

	require __DIR__ . '/../routes/api.v1.php';



    
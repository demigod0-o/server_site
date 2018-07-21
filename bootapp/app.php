<?php

use PDO;

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
	],
]);

$container = $app->getContainer();

$container['company_db'] = function () {
	return new PDO(
		'mysql:dbname=company;host=127.0.0.1',
		'root',
		'toor'
	);
};

$container['store_db'] = function () {
	return new PDO(
		'mysql:dbname=store;host=127.0.0.1',
		'root',
		'toor'
	);
};

require __DIR__ . '/../routes/api.v1.php';

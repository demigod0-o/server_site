<?php
use app\controllers\companyController;

$app->group('/company', function () {

	$this->get('/{id}', companyController::class . ':index');

	$this->post('/register', companyController::class . ':register');

	$this->post('/login', companyController::class . ':login');

	$this->post('/transation', companyController::class . ':transation');

});

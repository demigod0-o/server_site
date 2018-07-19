<?php
use app\controllers\companyController;

$app->group('/company', function () {

	$this->post('/register', companyController::class . ':register');

	$this->post('/login', companyController::class . ':login');

	$this->post('/transaction', companyController::class . ':transaction');

});

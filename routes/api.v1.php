<?php 
	use app\controllers\companyController;
	use app\controllers\controller;

	$app->group('/company',function(){
			
			$this->get('/{id}',companyController::class . ':index');

			$this->post('/register',companyController::class . ':register');

	});



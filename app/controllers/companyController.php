<?php

namespace app\controllers;

use app\models\CompanyLogin;
use app\models\CompanyRegister;
use app\models\CompanyTransaction;

class companyController extends controller {

	function register($request, $response) {

		$company = new CompanyRegister($request->getParsedBody(), $this->c->company_db);

		if ($company->save()) {

			if ($company->saveAccount()) {
				$this->response_message = [
					'message' => 'registeration is success',
					'error' => false,
				];
				$this->status_code = 201;
			}

		} else {

			$this->response_message = [
				'message' => $company->errors,
				'error' => true,
			];
			$this->status_code = 406;
		}

		return $response->withJson($this->response_message, $this->status_code);
	}

	function login($request, $response) {

		$company = new CompanyLogin($request->getParsedBody(), $this->c->company_db);

		if ($company->loginCredential()) {

			$this->response_message = [
				'access_token' => $company->access_token,
				'message' => 'login success',
				'error' => false,
			];
			$this->status_code = 200;

		} else {

			$this->response_message = [
				'message' => 'login failed',
				'error' => true,
			];
			$this->status_code = 200;
		}

		return $response->withJson($this->response_message, $this->status_code);

	}

	/* This transation method is used for transfer money from company */
	function transaction($request, $response) {

		$company = new CompanyTransaction($request->getParsedBody(), $this->c->company_db);

		if ($company->makeTransation()) {

			$this->response_message = [
				'message' => 'transaction success',
				'error' => false,
			];
			$this->status_code = 201;

		} else {
			$this->response_message = [
				'message' => 'transaction failed',
				'error' => false,
			];
			$this->status_code = 406;
		}

		return $response->withJson($this->response_message, $this->status_code);
	}

}

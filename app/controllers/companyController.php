<?php

namespace app\controllers;

use app\models\Company;

class companyController extends controller {

	function index($request, $response, $args) {

	}

	function register($request, $response) {

		$company = new Company($request->getParsedBody(), $this->c->db);

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

		$company = new Company($request->getParsedBody(), $this->c->db);

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
			$this->status_code = 401;
		}

		return $response->withJson($this->response_message, $this->status_code);

	}

	/* This transation method is used for transfer money from company */
	function transation($request, $response) {

		$company = new Company($request->getParsedBody(), $this->c->db);

		if ($company->makeTransation()) {
			echo "transation success";
		} else {
			echo "transation failed";
		}
	}

}

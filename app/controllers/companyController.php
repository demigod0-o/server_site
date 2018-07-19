<?php

namespace app\controllers;

use app\models\Company;

class companyController extends controller {

	function index($request, $response, $args) {

	}

	/*
		*	company registeration route requires these
		*
		*	name->for company
		*	agent_name-> for agent
		*	phone->
		*	email->
		*	address->
		*	nrc->
	*/
	function register($request, $response) {

		$company = new Company($request->getParsedBody());

		if ($company->save($this->c->db)) {
			$this->response_message = [
				'message' => 'successfully register',
				'error' => false,
			];
			$this->status_code = 201;
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

		$company = new Company($request->getParsedBody());

		if ($company->performLogin($this->c->db)) {
			$this->response_message = [
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
	function transation($request, $response) {

		$company = new Company($request->getParsedBody());

		if ($company->makeTransation($this->c->db)) {
			echo "transation success";
		} else {
			echo "transation failed";
		}
	}

}

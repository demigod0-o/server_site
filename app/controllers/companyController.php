<?php 

namespace app\controllers;

use app\models\Company;

class companyController extends controller
{

	function index( $request ,$response ,$args){

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
	function register( $request ,$response){

		$company = new Company($request->getParsedBody());

		if ($company->save($this->c->db)) {
			echo 'save';
		}else{
			echo 'no';
		}		
	}

}


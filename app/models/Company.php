<?php

namespace app\models;

class Company {

	public $errors = [];
	public $access_token;
	protected $db;

	function __construct($data, $db) {

		$this->db = $db;

		foreach ($data as $key => $value) {
			$this->$key = $value;
		};

	}

}

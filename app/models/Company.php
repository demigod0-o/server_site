<?php

namespace app\models;

use PDO;

class Company {

	public $errors = [];

	function __construct($data) {
		foreach ($data as $key => $value) {
			$this->$key = $value;
		};
	}

	function validate() {

		if ($this->name == '') {
			$this->errors[] = 'name is require';
		}

		if ($this->agent_name == '') {
			$this->errors[] = 'agent name is require';
		}

		if ($this->phone == '') {
			$this->errors[] = 'phone no is require';
		}

		if ($this->address == '') {
			$this->errors[] = 'address is require';
		}

		if ($this->nrc == '') {
			$this->errors[] = 'nrc is require';
		}

		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
			$this->errors[] = 'invalid email';
		}

		if ($this->password == '') {
			$this->errors[] = 'Password is require';
		}

		// if (strlen($this->password) < 6) {
		//     $this->errors[] = 'Please enter at least 6 characters for the password';
		// }

		// if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
		//     $this->errors[] = 'Password needs at least one letter';
		// }

		// if (preg_match('/.*\d+.*/i', $this->password) == 0) {
		//     $this->errors[] = 'Password needs at least one number';
		// }

	}

	public function save($db) {
		$this->validate();

		if (empty($this->errors)) {

			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);

			$this->id = md5($this->phone);

			$dat = date('d/m/Y');

			$sql =
				'INSERT INTO company ( id, name, agent_name, nrc, phone, email, password, address, date)
             VALUES (:id, :name, :agent_name, :nrc, :phone, :email, :password , :address , :dat)';

			$stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':agent_name', $this->agent_name, PDO::PARAM_STR);
			$stmt->bindValue(':nrc', $this->nrc, PDO::PARAM_STR);
			$stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
			$stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
			$stmt->bindValue(':dat', $dat, PDO::PARAM_STR);

			return $stmt->execute();
		}

		return false;
	}

	private function loginValidate() {
		if ($this->phone == '') {
			$this->errors = 'phone number is require';
		}
		if ($this->password == '') {
			$this->errors = 'password is require';
		}
	}

	public function performLogin($db) {

		$this->loginValidate();

		if (empty($this->errors)) {

			$sql = "SELECT * FROM  company WHERE phone = :phone ";

			$stmt = $db->prepare($sql);

			$stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$result = $stmt->fetch();

			return password_verify($this->password, $result['password']);
		}

		return false;

	}

	function makeTransation($db) {
		$this->transationValidate();

		if (empty($this->errors)) {
			$dat = date('Y/m/d');

			echo $dat;

			$transation_id = md5($this->target_phone);

			echo $transation_id;

			$sql =
				'INSERT INTO transation_history ( id , phone, amount, transation_id , date)
             VALUES (:id, :phone, :amount, :transation_id, :dat)';

			$stmt = $db->prepare($sql);

			$stmt->bindValue(':id', $this->company_id, PDO::PARAM_STR);

			$stmt->bindValue(':phone', $this->target_phone, PDO::PARAM_STR);

			$stmt->bindValue(':amount', $this->transfer_amount, PDO::PARAM_STR);

			$stmt->bindValue(':transation_id', $transation_id, PDO::PARAM_STR);

			$stmt->bindValue(':dat', $dat, PDO::PARAM_STR);

			var_dump($stmt);

			return $stmt->execute();
		}

		return false;
	}

	function transationValidate() {
		if ($this->target_phone == '') {
			$this->errors[] = 'target phone number is require';
		}
		if ($this->transfer_amount == '') {
			$this->errors[] = 'target phone number is require';
		}
		if ($this->phone_operator == '') {
			$this->errors[] = 'target phone number is require';
		}

	}

	function addCreditAmount() {

	}
}

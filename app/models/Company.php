<?php

namespace app\models;

use PDO;

class Company {

	public $errors = [];
	private $db;

	public $access_token;

	function __construct($data, $db) {

		$this->db = $db;

		foreach ($data as $key => $value) {
			$this->$key = $value;
		};

	}

	function validate() {

		if (
			$this->company_name != '' and $this->agent_name != '' and
			$this->agent_nrc != '' and $this->agent_address != '' and
			$this->company_address != '' and $this->phone != '' and
			$this->company_email != '' and $this->agent_email != '' and
			$this->password != '') {

			if (filter_var($this->company_email, FILTER_VALIDATE_EMAIL) === false) {
				$this->errors[] = 'company email is invalid !';
			}
			if (filter_var($this->agent_email, FILTER_VALIDATE_EMAIL) === false) {
				$this->errors[] = 'agent email is invalid !';
			}

		} else {

			$this->errors[] = 'require fields are missing';

		}

	}

	public function save() {

		$this->validate();

		if (empty($this->errors)) {

			$encript_password = password_hash($this->password, PASSWORD_DEFAULT);

			$this->id = md5($this->phone);

			$sql =
				'INSERT INTO company
				( id, company_name, agent_name,
				  agent_nrc, agent_address,
				  company_address, phone,
				  company_email, agent_email,
				  password )
             	VALUES
             	( :id, :company_name, :agent_name,
				  :agent_nrc, :agent_address,
				  :company_address, :phone,
				  :company_email, :agent_email,
				  :password )';

			$stmt = $this->db->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_STR);

			$stmt->bindValue(':company_name', $this->company_name, PDO::PARAM_STR);

			$stmt->bindValue(':agent_name', $this->agent_name, PDO::PARAM_STR);

			$stmt->bindValue(':agent_nrc', $this->agent_nrc, PDO::PARAM_STR);

			$stmt->bindValue(':agent_address', $this->agent_address, PDO::PARAM_STR);

			$stmt->bindValue(':company_address', $this->company_address, PDO::PARAM_STR);

			$stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);

			$stmt->bindValue(':company_email', $this->company_email, PDO::PARAM_STR);

			$stmt->bindValue(':agent_email', $this->agent_email, PDO::PARAM_STR);

			$stmt->bindValue(':password', $encript_password, PDO::PARAM_STR);

			if ($stmt->execute()) {

				return true;

			} else {

				$this->errors[] = 'your account already register';

				return false;
			}
		}

		return false;
	}

	public function saveAccount() {

		$sql = 'INSERT INTO account ( id, access_token, last_login, account_status,	wallet_amount )
             VALUES ( :id, :access_token, :last_login, :account_status,	:wallet_amount )';

		$stmt = $this->db->prepare($sql);

		$encript_data = date('d-m-Y') . $this->phone;

		$access_token = hash('sha256', $encript_data);

		$stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
		$stmt->bindValue(':access_token', $access_token, PDO::PARAM_STR);
		$stmt->bindValue(':last_login', null, PDO::PARAM_STR);
		$stmt->bindValue(':account_status', 1, PDO::PARAM_STR);
		$stmt->bindValue(':wallet_amount', 0, PDO::PARAM_STR);

		return $stmt->execute();
	}

	private function loginValidate() {
		if ($this->phone == '') {
			$this->errors = 'phone number is require';
		}
		if ($this->password == '') {
			$this->errors = 'password is require';
		}
	}

	private function performLogin() {

		$this->loginValidate();

		if (empty($this->errors)) {

			$sql = "SELECT * FROM  company WHERE phone = :phone ";

			$stmt = $this->db->prepare($sql);

			$stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$result = $stmt->fetch();

			$this->id = $result['id'];
			return password_verify($this->password, $result['password']);
		}

		return false;

	}

	public function loginCredential() {
		if ($this->performLogin()) {

			$sql = "SELECT access_token FROM  account WHERE id = :id ";

			$stmt = $this->db->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_STR);

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$result = $stmt->fetch();

			$this->access_token = $result['access_token'];

			if (empty($this->access_token)) {
				return false;
			}
			return true;
		}
	}

	function makeTransation() {
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
		$sql = 'UPDATE account SET amount = amount + :amount WHERE id = :company_id';
	}
}

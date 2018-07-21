<?php

namespace app\models;
use PDO;

class CompanyLogin extends Company {

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

			$sql = "SELECT * FROM  info WHERE phone = :phone ";

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
}
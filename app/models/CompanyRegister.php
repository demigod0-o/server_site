<?php
namespace app\models;
use PDO;

class CompanyRegister extends Company {

	function validate() {
		if ($this->company_name != '' and $this->agent_name != '' and
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

			$sql = 'INSERT INTO company ( id, company_name, agent_name,agent_nrc, agent_address,
				  company_address, phone,company_email, agent_email, password )
             	VALUES ( :id, :company_name, :agent_name, :agent_nrc, :agent_address,
				  :company_address, :phone, :company_email, :agent_email, :password )';

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
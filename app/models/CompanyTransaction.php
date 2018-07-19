<?php
namespace app\models;
use PDO;

class CompanyTransaction extends Company {

	function makeTransation() {

		$this->transationValidate();

		if (empty($this->errors)) {

			$this->date_time = date('Y/m/d');

			$this->server_time = $_SERVER["REQUEST_TIME"];

			$this->transaction_id = md5($this->target_phone . $this->account_id . $this->server_time);

			$sql = 'INSERT INTO transaction_record ( transaction_id, account_id, amount, target_phone, target_operator, date_time ) VALUES (:transaction_id, :account_id, :amount, :target_phone, :target_operator, :date_time)';

			$stmt = $this->db->prepare($sql);

			$stmt->bindValue(':transaction_id', $this->transaction_id, PDO::PARAM_STR);
			$stmt->bindValue(':account_id', $this->account_id, PDO::PARAM_STR);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':target_phone', $this->target_phone, PDO::PARAM_STR);
			$stmt->bindValue(':target_operator', $this->target_operator, PDO::PARAM_STR);
			$stmt->bindValue(':date_time', $this->date_time, PDO::PARAM_STR);

			return $stmt->execute();
		}

		return false;
	}

	function transationValidate() {

		if ($this->target_phone == '') {
			$this->errors[] = 'target phone number is require';
		}

		if ($this->amount == '') {
			$this->errors[] = 'transfer_amount is require';
		}

		if ($this->amount < 1000) {
			$this->errors[] = 'transfer amount must be 1000 mmk at least';
		}

		if ($this->target_operator == '') {
			$this->errors[] = 'target operator  is require';
		}

	}

	function addCreditAmount() {
		$sql = 'UPDATE account SET amount = amount + :amount WHERE id = :company_id';
	}
}
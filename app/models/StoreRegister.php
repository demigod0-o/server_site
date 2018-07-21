<?php

class StoreRegister extends Store {

	function saveInfo() {

	}

	function validate() {

		if ($this->company_name != '' and $this->agent_name != '' and
			$this->agent_nrc != '' and $this->company_address != '' and
			$this->phone != '' and $this->company_email != '' and
			$this->agent_email != '' and $this->password != '') {

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
}
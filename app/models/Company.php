<?php 

namespace app\models;

use PDO;
/**
 * 
 */
class Company
{
	
	public $errors = [];

	function __construct($data)
	{
		foreach ($data as $key => $value) {
            $this->$key = $value;
        };
	}

	function validate(){


	   /*
			caompany name validate
	   */
	   if ($this->name == '') {
           $this->errors[] = 'name is require';
       }

       /*
			agent name validate
       */
       if ($this->agent_name == '') {
           $this->errors[] = 'agent name is require';
       }
   
       /*
			phone no validate
       */
       if ($this->phone == '') {
           $this->errors[] = 'phone no is require';
       }

       /*
			address validate
       */
       if ($this->address == '') {
           $this->errors[] = 'address is require';
       }

       /*
			nrc validate
       */
       if ($this->nrc == '') {
           $this->errors[] = 'nrc is require';
       }

       /*
			email validate
       */

       if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
           $this->errors[] = 'invalid email';
       }


       /*
			password validate
       */

       if ($this->password == '') {
           $this->errors[] = 'Password is require';
       }

       if (strlen($this->password) < 6) {
           $this->errors[] = 'Please enter at least 6 characters for the password';
       }


       if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one letter';
       }

       if (preg_match('/.*\d+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one number';
       }

	}


	public function save($db)
    {
        $this->validate();
    
        if (empty($this->errors)) {
          
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $this->id = md5($this->phone);
            $this->date = date('d/m/Y');

            $sql = 
            'INSERT INTO company ( id, name, agent_name, nrc, phone, email, password, address,date)
             VALUES (:id, :name, :agent_name, :nrc, :phone, :email, :password , :address , :date)';

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':agent_name', $this->agent_name, PDO::PARAM_STR);
            $stmt->bindValue(':nrc', $this->nrc, PDO::PARAM_STR);
            $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':address', $this->address, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
}

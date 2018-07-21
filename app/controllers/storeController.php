<?php
namespace app\controllers;

use app\StoreLogin.php;
use app\StoreRegister.php;
use app\StoreTransaction.php;

class storeController extends controller
{
	function Register( $requrest, $response){

		$store = new StoreRegister($request->getParsedBody(), $this->c->store_db);

		if ($store->saveInfo()) {
			
		}
	}
}

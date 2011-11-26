<?php

require_once('database.php');
require_once('classes/account.php');

class User
{
	private $user;
	private $pass;
	private $account;
	private $authenticated;

	public function __construct($u, $p = "")
	{
		$this->user = $u;
		$this->pass = $p;
		$this->authenticated = $this->authenticate();
		$this->account = $this->findAccount();
	}

	private function authenticate()
	{
		return db_authenticateUser($this->user, $this->pass);
	}

	public function isAuthenticated()
	{
		return $this->authenticated;
	}

	public function getAccount()
	{
		return $this->account;
	}

	private function findAccount()
	{
		$account = db_findAccount($this->user);
		if ($account !== false)
		{
			return new Account($account);
		}
		else
		{
			return null;
		}
	}

	public function hasAccount()
	{
		return ($this->account === null)? false : true;
	}
}

?>

<?php

require_once('classes/user.php');

class ECommerce
{
	
	public function __construct()
	{

	}

	/*** Public Methods ***************************************/
	public function webWithdraw($username, $userpass, $amt)
	{
		$user = new User($username, $userpass);
		if (($actual_amount = $this->withdraw($user, $amt)) !== false)
		{
			return "Amount withdrawn: $actual_amount";
		}
		else
		{
			return "Error: No account for specified user.";
		}
	}

	public function webDeposit($username, $userpass, $amt)
	{
		$user = new User($username, $userpass);
		if(($actual_amount = $this->deposit($user, $amt)) !== false)
		{
			return "New balance: $actual_amount";
		}
		else
		{
			return "Error: No account for specified user.";
		}
	}

	public function webTransfer($fusername, $fuserpass, $tusername, $tuserpass, $amt)
	{
		$fuser = new User($fusername, $fuserpass);
		$tuser = new User($tusername, $tuserpass);
		if (($actual_amount = $this->transfer($fuser, $tuser, $amt)) !== false)
		{
			return "Amount transferred: $actual_amount";
		}
		else
		{
			return "Error: No account for specified user.";
		}
	}

	public function webCheckBalance($username, $password)
	{
		$user = new User($username, $password);
		if (($balance = $this->checkBalance($user)) !== false)
		{
			return "Balance: $balance";
		}
		else
		{
			return "Error: No account for specified user.";
		}
	}
	/**********************************************************/


	private function withdraw($user, $amt)
	{
		if ($user->isAuthenticated() && $user->hasAccount())
		{
			return $user->getAccount()->withdraw($amt);
		}
		else
		{
			return false;
		}
	}

	private function deposit($user, $amt)
	{
		if ($user->isAuthenticated() && $user->hasAccount())
		{
			return $user->getAccount()->deposit($amt);
		}
		else
		{
			return false;
		}
	}

	private function transfer($fuser, $tuser, $amt)
	{
		if ($fuser->isAuthenticated() && $fuser->hasAccount() && $tuser->isAuthenticated() && $tuser->hasAccount())
		{
			return $tuser->getAccount()->deposit($fuser->getAccount()->withdraw($amt));
		}
		else
		{
			return false;
		}
	}

	private function checkBalance($user)
	{
		if ($user->isAuthenticated() && $user->hasAccount())
		{
			return $user->getAccount()->getBalance();
		}
		else
		{
			return false;
		}
	}
}

?>

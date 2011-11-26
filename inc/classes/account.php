<?php

require_once('database.php');

class Account
{
	private $number;
	private $balance;

	public function __construct($n)
	{
		$this->number = $n;
		$this->balance = $this->findBalance();
	}

	public function getBalance()
	{
		return $this->balance;
	}

	private function findBalance()
	{
		return db_findBalance($this->number);
	}

	public function getNumber()
	{
		return $this->number;
	}

	// returns amount withdrawn
	public function withdraw($amount)
	{
		$actual_amount;
		if ($this->balance >= $amount)
		{
			$this->balance -= $amount;
			$actual_amount = $amount;
		}
		else
		{
			$actual_amount = $this->balance;
			$this->balance = 0;
		}

		// synch with db
		db_setBalance($this->number, $this->balance);
		return $actual_amount;
	}

	// returns new balance
	public function deposit($amount)
	{
		$this->balance += $amount;

		// synch with db
		db_setBalance($this->number, $this->balance);
		return $this->balance;
	}
}

?>

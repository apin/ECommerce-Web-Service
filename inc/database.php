<?php

require_once('config.php');

// returns true / false
function db_authenticateUser($username, $password)
{
	$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if ($db->connect_errno)
	{
		die('Error connecting to database (' . $db->connect_errno . ') ' . $db->connect_error);
	}

	$stmt = $db->prepare('SELECT password FROM user WHERE username=?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($p);
	
	$authenticated = false; // default
	if ($stmt->fetch())
	{
		if ($password === $p)
		{
			$authenticated = true;
		}
	}
	
	$stmt->close();
	$db->close();

	return $authenticated;
}

// returns balance or false
function db_findBalance($account)
{
	$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if ($db->connect_errno)
	{
		die('Error connecting to database (' . $db->connect_errno . ') ' . $db->connect_error);
	}

	$stmt = $db->prepare('SELECT balance FROM account WHERE id=?');
	$stmt->bind_param('i', $account);
	$stmt->execute();
	$stmt->bind_result($b);

	$balance = false;
	if ($stmt->fetch())
	{
		$balance = $b;
	}

	$stmt->close();
	$db->close();

	return $balance;
}

// returns account number or false
function db_findAccount($username)
{
	$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if ($db->connect_errno)
	{
		die('Error connecting to database (' . $db->connect_errno . ') ' . $db->connect_error);
	}

	$stmt = $db->prepare('SELECT account FROM user WHERE username=?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($a);

	$account = false;
	if ($stmt->fetch())
	{
		$account = $a;
	}

	$stmt->close();
	$db->close();

	return $account;
}

// returns true / false
function db_setBalance($account, $balance)
{
	$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if ($db->connect_errno)
	{
		die('Error connecting to database (' . $db->connect_errno . ') ' . $db->connect_error);
	}

	$stmt = $db->prepare('UPDATE account SET balance=? WHERE id=?');
	$stmt->bind_param('ii', $balance, $account);
	$ret = $stmt->execute();

	$stmt->close();
	$db->close();
	
	return $ret;
}

?>

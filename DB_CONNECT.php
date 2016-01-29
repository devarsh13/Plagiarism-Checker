<?php

class DB_connect{

	public function connect()
	{
		require_once 'config.php';
		$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE) or die(mysql_error());
		
		return $con;
	}
	public function close()
	{
		myaql_close();
	}
}

?>
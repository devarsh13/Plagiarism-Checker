
<?php
class DB_FUNCTIONS
{
	private $db;
	private $con;
	private  static $counter=0;
	function __construct()
	{
		require_once 'DB_CONNECT.php';
		$this->db=new DB_CONNECT();
		$this->con=$this->db->connect();
		
		
	}
	
	public function validUser($email,$password)
	{
		
		$query="SELECT `email` FROM `users` WHERE  `password_encrypted`='$password' AND `email` ='$email' ";
		
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con)); 
		$rows=mysqli_num_rows($result);
		if($rows==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	
	}
	public function userExists($email)
	{
		
		$query="SELECT `email` FROM `users` WHERE `email`='$email'";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
		$rows=mysqli_num_rows($result);
		
		if($rows==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function storeUser($email,$password,$fn,$ln)
	{
		$password_encrypted=md5($password);
		$query="INSERT INTO `users`(`email`,`password_encrypted`,`first_name`,`last_name`)VALUES('$email','$password_encrypted','$fn','$ln')";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
		
	}
	
	
	public  function storeFingerPrints($filename,$fingerprint,$fingerprint_ind)
	
	{
		
		$query="INSERT INTO `fingerprints` (`filename`,`fingerprint`,`fingerprint_ind`)VALUES('$filename','$fingerprint','$fingerprint_ind')";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
		
	}
	
	public function selectFingerPrint($i)
	{
		$query="SELECT `fingerprint`,`filename` FROM `fingerprints` WHERE `id`='$i'";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
		$a=$result->fetch_assoc();
		return $a;
	}
	
	public  function delete()
	{
		$query="DELETE FROM `fingerprints` ";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
		$query="ALTER TABLE `fingerprints` AUTO_INCREMENT=1";
		$result=mysqli_query($this->con,$query) or die(mysqli_error($this->con));
	}
}
?>
<h1><div align="center">CHECK PLAG</div></h1>
<?php
	require 'DB_FUNCTIONS.php';
	$db=new DB_FUNCTIONS();
	if(isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['password']) and !empty($_POST['password']) and isset($_POST['un']) and !empty($_POST['un'])  and isset($_POST['confirmpassword']) and !empty($_POST['confirmpassword']))
	{
		$email=$_POST['email'];
		$password=$_POST['password'];
		$un=$_POST['un'];
		
		$confirmpassword=$_POST['confirmpassword'];
		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$emailerr="Invalid email";
			echo $emailerr;
		}
		else
		{
			
			if(!($password==$confirmpassword))
			{
				$passworderr="Passwords Don't match";
				echo $passworderr;
			}
			else
			{
				$a=$db->userExists($email);
				if($a==true)
				{
					echo "email aldready exists";
				}
				else
				{
					$db->storeUser($email,$password,$un);
				}
			}
		}
		
	}
	else
	{
			
	}
	

?>

<form action="register.php" method="POST">
	<strong> ALL FIELDS ARE MANDATORY </strong><br><br>
	email<br>
	<input type="text" name="email"><br><br>
	Username<br>
	<input type="text" name="un"><br><br>
	
	Password<br>
	<input type="password" name="password"><br><br>
	Confirm Password<br>
	<input type="password" name="confirmpassword"><br><br>
	<input type="submit" name="submit">
</form>
	
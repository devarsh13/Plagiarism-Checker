<h1><div align="center">CHECK PLAG</div></h1>
<?php 
	require 'DB_FUNCTIONS.php';
	
	
	$db=new DB_FUNCTIONS();
	
	
	if(isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['password']) and !empty($_POST['password']))
	{
		$email=$_POST['email'];
		$password=$_POST['password'];
		$password_encrypted=md5($password);
		$a=$db->validUser($email,$password_encrypted);
		if($a==true)
		{
			setcookie('email',$email,time()+86400);
			//header("Location:checkplag.php");
		}
		else
		{
			echo "invalid email or password";
			
		}
		
	}
	else{
		if(isset($_POST['email']) and isset($_POST['password']))
		{
			echo "<strong>ALL FIELDS ARE REQUIRED</strong>";
		}
		
		}
?>
<form action="index.php" method="POST">
	email<br>
	<input type="text" name="email">
	<br>
	PASSWORD<br>
	<input type="password" name="password">
	<br><br>
	<input type="submit" name="submit">
	<br>
	
</form>
Not a member?<strong><a href="register.php">REGISTER</a></strong>

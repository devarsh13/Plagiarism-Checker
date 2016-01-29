<h1><div align="center">CHECK PLAG</div></h1>
<strong>MAKE A ZIP FOLDER OF  ALL THE DOCUMENTS ON WHICH YOU WANT TO CHECK FOR PLAGIARISM AND UPLOAD IT BELOW.</strong><br><br>
<?php


if(isset($_FILES['file']['name']))
{
	if(!empty($_FILES['file']['name']))
	{
		$location="uploads/";
		$name=$_FILES['file']['name'];
		$tmp_name=$_FILES['file']['tmp_name'];
		
		$a=new SplFileInfo($name);
		$extension=($a->getExtension());
		if($extension!="zip")
		{
			echo "upload only zip files";
		}
		
		else
		{
			$files = glob("uploads/*"); 
			
			foreach($files as $file)
			{ 
				echo $file;	
				if(is_file($file)){
					unlink($file); }
			}
			move_uploaded_file($tmp_name,$location.$name);
			include_once 'DB_FUNCTIONS.php';
			$db=new DB_FUNCTIONS();
			$db->delete_fingerprints();
			$db->delete_result();
			header("Location:checking.php");
			
		}
		
	}
	else
	{
		echo "choose a file";	
	}
}
	
?>


<form action="checkplag.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="file"><br><br>
	<input type="submit" name="submit">
</form>
<h1><div align="center">CHECKING FOR PLAGIARISM PLEASE WAIT<div></h1>
<?php
	
	require 'fingerprinting.php';
	require 'DB_FUNCTIONS.php';
	$fp=new fingerPrinting();
	$files=glob("uploads/*");
	delete_directory("uploads/ffcp");
	$zip=new ZipArchive;
	foreach($files as $file)
	{
		@$res=$zip->open($file);
		if($res===true)
		{
			@$zip->extractTo('uploads/ffcp/');
			$zip->close();
			
		}
		
	}
	
	
	$files=glob("uploads/ffcp/*");
	
	foreach($files as $file)
	{
		//echo $file;
		include_once('PDF2TEXT.php');
		include_once('DOCTOTEXT.php');
		$a=new SplFileInfo($file);
		$extension=($a->getExtension());
		//echo $extension;
		if($extension=='pdf')
		{
			//echo "asdsad";
			$a=new PdfParser();
			$data=$a->parseFile($file);
			
			$data=preg_replace('/[^A-Za-z0-9]/','',$data);
			//echo $data;
			$handle=fopen("one.txt",'w');
			fwrite($handle,$data);
			$fp->fingerPrint($file);
		}
		else if($extension=='docx')
		{
			$docobj=new DocxConversion($file);
			$data=$docobj->convertToText();
			$data=preg_replace('/[^A-Za-z0-9]/','',$data);
			$handle=fopen("one.txt",'w');
			fwrite($handle,$data);
			$fp->fingerPrint($file);
		}
		else if($extension=='doc')
		{
			$docobj=new DocxConversion($file);
			$data=$docobj->convertToText();
			$data=preg_replace('/[^A-Za-z0-9]/','',$data);
			$handle=fopen("one.txt",'w');
			fwrite($handle,$data);
			$fp->fingerPrint($file);
		}
		else if($extension='txt')
		{
			$handle=fopen($file,'r');
			$data=file_get_contents($file);
			$data=preg_replace('/[^A-Za-z0-9]/','',$data);
			$handle=fopen("one.txt",'w');
			fwrite($handle,$data);
			$fp->fingerPrint($file);
		}
		

	}
	$fp->query_fingerprint();
	
	
	
function delete_directory($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
	 if (!$dir_handle)
	      return false;
	 while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
	            if (!is_dir($dirname."/".$file))
	                 unlink($dirname."/".$file);
	            else
	                 delete_directory($dirname.'/'.$file);
	       }
	 }
	 closedir($dir_handle);
	 @rmdir($dirname);
	 return true;
}
?>

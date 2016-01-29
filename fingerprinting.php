<?php


class fingerPrinting
{
	public function fingerPrint($file)
	{
		
		
		$db=new DB_FUNCTIONS();
	
		
		
		$handle=fopen("one.txt","r");
		$data=file_get_contents("one.txt");
		$data=strtolower($data);
		//echo $data;
		$threshhold=25;
		$kmin=7;
		$window=$threshhold-$kmin+1;
		$kgrams=array();
		$counter=0;
		for($i=0;$i<strlen($data)-$kmin;$i++)
		{
			$temp="";
			for($j=$i;$j<$i+$kmin;$j++)
			{
				$temp=$temp.substr($data,$j,1);
			}
			$kgrams[$counter]=$temp;
			$counter++;
		}
		$hash=array();
		$prev_hash=-1;
		$counter=0;
		$base=73;
		$charrem="";
		
		foreach($kgrams as $kgram)
		{
			if($prev_hash==-1)
			{
				$h=0;
				$c=0;
				for($i=0;$i<$kmin;$i++)
				{
					$h=$h+ord(substr($kgram,$i,1))*pow($base,$c);
					$c++;
					
				}
				$prev_hash=$h;
				$hash[$counter]=$prev_hash;
				$charrem=substr($kgram,0,1);
			}
			else
			{
				$prev_hash=($prev_hash-ord($charrem))/101+ord(substr($kgram,$kmin-1,1))*pow($base,$kmin-1);
				$hash[$counter]=$prev_hash;
				$charrem=substr($kgram,0,1);
			}
			$counter++;
		}
		
		$prev_min=-1;
		$prev_min_ind=0;
		$curr_min=-1;
		$curr_min_ind=0;
		$fingerprint_value=array();
		$fingerprint_ind=array();
		$counter=0;
		for($i=0;$i<$window;$i++)
		{
			if($curr_min==-1 or $hash[$i]<=$curr_min)
			{
				$curr_min=$hash[$i];
				$curr_min_ind=$i;
			
			}
			
		}
		$fingerprint_value[$counter]=$curr_min;
		$fingerprint_ind[$counter]=$curr_min_ind;
		$counter++;
		$prev_min=$curr_min;
		$prev_min_ind=$curr_min_ind;
		for($i=1;$i<sizeof($hash)-$window+1;$i++)
		{
			$curr_min=-1;
			$curr_min_ind=0;
			
			for($j=$i;$j<$i+$window;$j++)
			{
				if($curr_min==-1 or $hash[$j]<=$curr_min)
				{
					$curr_min=$hash[$j];
					$curr_min_ind=$j;
			
				}
			}
			if($prev_min_ind>=$i)
			{
				if($curr_min<=$prev_min and $curr_min_ind>$prev_min_ind)
				{
					$prev_min=$curr_min;
					$prev_min_ind=$curr_min_ind;
					$fingerprint_ind[$counter]=$prev_min_ind;
					$fingerprint_value[$counter]=$prev_min;
					$counter++;
				}
				
			}
			else
			{
				$prev_min=$curr_min;
				$prev_min_ind=$curr_min_ind;
				$fingerprint_ind[$counter]=$prev_min_ind;
				$fingerprint_value[$counter]=$prev_min;
				$counter++;
			}
		}
		
		
		$finpri=implode($fingerprint_value,"$");
		$finpri_ind=implode($fingerprint_ind,"$");
		$c=sizeof($fingerprint_value);
		
		$db->storeFingerPrints($file,$finpri,$finpri_ind,$c);
		
		
	}
	public function query_fingerprint()
	{
		unlink("result.zip");
		unlink("result.txt");
		$handle=fopen("result.txt",'a');
		$db=new DB_FUNCTIONS();
		$files=scandir("uploads/ffcp/");
		$x=count($files)-2;
		
		for($i=1;$i<=$x;$i++)
		
		{
			$a= $db->selectFingerPrint($i);
			$b= explode("$",$a['fingerprint']);
			$count=$a['count'];
			
			
			for($j=$i+1;$j<=$x;$j++)
			{
				$n=0;
				$c=$db->selectFingerPrint($j);
				$d=explode("$",$c['fingerprint']);
				foreach($d as $cd)
				{
					foreach($b as $ab)
					{
						if($ab==$cd)
						{
							$n+=1;
						}
					}
				}
				if($n>=0)
				{
					
					$percentage=($n/$count)*100;
					$db->storeResult($a['filename'],$c['filename'],$percentage);
					
					
				}
			}
		}
		$result=$db->getResult();
		while($r=mysqli_fetch_assoc($result)){
		
			fwrite($handle,$r['file1']."\r\n".$r['file2']."\r\n".$r['percentage']."\r\n");
		}
		
		$db->delete_result();
		$db->delete_fingerprints();
		$zip = new ZipArchive();
		$zip->open('result.zip',  ZipArchive::CREATE);
		$zip->addFile("result.txt");
		$zip->close();
		header("Location:download.php");
		
	}
	
}
?>	

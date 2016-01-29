<?php
class d{
private $filename;
function __construct($filename)
{
	$this->filename=$filename;
}
public function read_doc() {
    $fileHandle = fopen($this->filename, "r");
    $line = @fread($fileHandle, filesize($this->filename));   
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
      {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
          {
          } else {
            $outtext .= $thisline." ";
          }
      }
     $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
    return $outtext;
}}?>
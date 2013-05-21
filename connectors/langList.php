<?php
header('Content-type: application/json');
$files = scandir('../json/') or die("hata");
natcasesort($files);
echo '{';
for($i=2;$i < count($files);$i++){
	
	if(preg_match('/(\.*).json\b/',$files[$i])){ 
		echo '"'.$files[$i].'":"'.preg_replace('/(\w+)_(\w+).(\w+)/i','$2',$files[$i]).'"'; 
	}
	echo (($i<(count($files)-1))? ",":"" );
}
echo '}';
?>
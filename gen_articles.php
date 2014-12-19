<?php

$alphabet = array("01"=>"A","02"=>"B","03"=>"C","04"=>"D","05"=>"E","06"=>"F","07"=>"G","08"=>"H","09"=>"I","10"=>"J","11"=>"K","12"=>"L","13"=>"M","14"=>"N","15"=>"O","16"=>"P","17"=>"Q","18"=>"R","19"=>"S","20"=>"T","21"=>"U","22"=>"V","23"=>"W","24"=>"X","25"=>"Y","26"=>"Z");

for($ia=1;$ia<=sizeof($alphabet);$ia++)
{
	$letter = $alphabet{str_pad($ia, 2, "0", STR_PAD_LEFT)};
	
	$filename = "html/articles_" . str_pad($ia, 2, "0", STR_PAD_LEFT) . ".html";

	$cmd = 'wget "http://localhost/vk/html/articles.php?letter=' . $letter . '" --output-document=' . $filename . ' --quiet';

	system($cmd);
}

?>

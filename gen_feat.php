<?php

require_once("html/connect.php");

$query = "select * from feature order by feat_name";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

for($i=1;$i<=$num_rows;$i++)
{
	$row = $result->fetch_assoc();
	$featid=$row['featid'];
	$feat_name=$row['feat_name'];

	$filename = "html/feat_" . $featid . ".html";

	$cmd = 'wget "http://localhost/vk/html/feat.php?feature=' . $feat_name . '&featid=' . $featid . '" --output-document=' . $filename . ' --quiet';

	system($cmd);
}
?>

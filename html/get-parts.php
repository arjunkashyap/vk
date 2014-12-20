<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['volume'])){$volume = $_GET['volume'];}else{$volume = '';}

if(!(isValidVolume($volume)))
{
	exit(1);
}

$query = "select distinct part,month from article where volume='$volume' order by part";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

echo '<div id="issueHolder" class="issueHolder"><div class="issue">';

if($num_rows > 0)
{
	$isFirst = 1;
	while($row = $result->fetch_assoc())
	{
		echo (($row['month'] == '01') && ($isFirst == 0)) ? '<div class="deLimiter">|</div>' : '';
		echo '<div class="aIssue"><a href="toc_' . $volume . '_' . $row['part'] . '.html">' . getMonth($row['month']) . '</a></div>';
		$isFirst = 0;
	}
}

echo '</div></div>';

if($result){$result->free();}
$db->close();

?>
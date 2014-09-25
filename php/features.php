<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder">
			<div class="page_title"><i class="fa fa-tags"></i>&nbsp;&nbsp;Categories</div>
				<ul class="dot">
<?php

include("connect.php");

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo '<li>Not connected to the database [' . $db->connect_errno . ']</li>';
	echo "</ul>";
    echo "</div></div>";
    include("include_footer.php");
	exit(1);
}


$query = "select * from feature order by feat_name";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;


if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
				$row = $result->fetch_assoc();
		
		$feat_name=$row['feat_name'];
		$featid=$row['featid'];

		if($feat_name != "")
		{
			echo "<li>";
			echo "<span class=\"featurespan\"><a href=\"feat.php?feature=" . urlencode($feat_name) . "&amp;featid=$featid\">$feat_name</a></span>";
			echo "</li>\n";
		}
	}
}
else
{
	echo "No data in the database";
}

if($result){$result->free();}
$db->close();

?>
				</ul>
			</div>
	</div>
    
<?php include("include_footer.php");?>

<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder_volume">
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['vol'])){$volume = $_GET['vol'];}else{$volume = '';}
if(isset($_GET['year'])){$year = $_GET['year'];}else{$year = '';}

if(!(isValidVolume($volume) && isValidYear($year)))
{
	echo "Invalid URL";
	
	echo "</div></div>";
	include("include_footer.php");
	echo "<div class=\"clearfix\"></div></div>";
	include("include_footer_out.php");
	echo "</body></html>";
	exit(1);
}

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo 'Not connected to the database [' . $db->connect_errno . ']';
	echo "</div></div>";
	include("include_footer.php");
	echo "<div class=\"clearfix\"></div></div>";
	include("include_footer_out.php");
	echo "</body></html>";
	exit(1);
}

echo "<div class=\"page_title\"><i class='fa fa-book fa-1x'></i>&nbsp;&nbsp;".$year."&nbsp;(Volume&nbsp;".intval($volume).")</div>";
?>
			<div class="col1">
				<ul>

<?php

$row_count = 4;
$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct part from article where volume='$volume' order by part";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

$count = 0;
$col = 1;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		$row = $result->fetch_assoc();
		
		$part=$row['part'];
		
		$query1 = "select distinct month from article where volume='$volume' and part='$part' order by month";

		$result1 = $db->query($query1); 
		$num_rows1 = $result1 ? $result1->num_rows : 0;

		if($num_rows1 > 0)
		{
			$row1 = $result1->fetch_assoc();
			$month = $row1['month'];

			$count++;
			if($count > $row_count)
			{
				$col++;
				echo "</ul></div>\n<div class=\"col$col\">\n<ul>";
				$count = 1;
			}
			
			$dpart = preg_replace("/^0/", "", $part);
			$dpart = preg_replace("/\-0/", "-", $dpart);
			
			echo "<li class=\"li_below\"><span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;part=$part\">".$month_name{intval($month)};
			if(intval($month) != 0)
			{
				echo "&nbsp;(Issue&nbsp;".$dpart.")";
			}
			echo "</a></span></li>";
		}
		if($result1){$result1->free();}
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
	</div>
    
<?php include("include_footer.php");?>

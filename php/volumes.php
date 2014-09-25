<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder_volume">
			<div class="page_title"><i class="fa fa-book"></i>&nbsp;&nbsp;Volumes</div>
			<div class="col1"><ul>
<?php

include("connect.php");

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo '<li>Not connected to the database [' . $db->connect_errno . ']</li>';
	echo "</ul></div></div></div>";
	echo "<div class=\"clearfix\"></div></div>";
	echo "</body></html>";
	exit(1);
}


$row_count = 25;

$query = "select distinct volume from article order by volume";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;


$count = 0;
$col = 1;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
				$row = $result->fetch_assoc();
		$volume=$row['volume'];

		$query1 = "select distinct year from article where volume='$volume'";
		
						$result1 = $db->query($query1); 
		$num_rows1 = $result1 ? $result1->num_rows : 0;
		
		if($num_rows1 > 0)
		{
			for($i1=1;$i1<=$num_rows1;$i1++)
			{
								$row1 = $result1->fetch_assoc();
				
				if($i1==1)
				{
					$year=$row1['year'];
				}
				else if($i1==2)
				{
					$year2 = $row1['year'];
					$year21 = preg_split('//',$year2);
					$year=$year."-".$year21[3].$year21[4];
				}
			}
			$count++;
			$volume_int = intval($volume);
			if($count > $row_count)
			{
				$col++;
				echo "</ul></div>\n
				<div class=\"col$col\"><ul>";
				$count = 1;
			}
			echo "<li><span class=\"yearspan\"><a href=\"part.php?vol=$volume&amp;year=$year\">Volume $volume_int ($year)</a></span></li>";
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

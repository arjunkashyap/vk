<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder">
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['vol'])){$volume = $_GET['vol'];}else{$volume = '';}
if(isset($_GET['part'])){$part = $_GET['part'];}else{$part = '';}

if(!(isValidVolume($volume) && isValidPart($part)))
{ 
	echo "Invalid URL";
	
	echo "</ul>";
    echo "</div></div>";
    include("include_footer.php");
	exit(1);
}

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo 'Not connected to the database [' . $db->connect_errno . ']';
	echo "</div></div>";
    include("include_footer.php");
	exit(1);
}



$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct year,month from article where volume='$volume' and part='$part'";


$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
		$row = $result->fetch_assoc();

	$month=$row['month'];
	$year=$row['year'];
	
	$dpart = preg_replace("/^0/", "", $part);
	$dpart = preg_replace("/\-0/", "-", $dpart);
	
	echo "<div class=\"page_title\"><i class='fa fa-book fa-1x'></i>&nbsp;&nbsp;".$year."&nbsp;".$month_name{intval($month)}."&nbsp;;&nbsp;&nbsp;(Volume&nbsp;".intval($volume).",&nbsp;Issue&nbsp;".$dpart.")</div>";
	echo "<ul class=\"dot\">";
}

if($result){$result->free();}

$query1 = "select * from article where volume='$volume' and part='$part' order by page";

$result1 = $db->query($query1); 
$num_rows1 = $result1 ? $result1->num_rows : 0;


if($num_rows1 > 0)
{
	for($i=1;$i<=$num_rows1;$i++)
	{
				$row1 = $result1->fetch_assoc();

		$titleid=$row1['titleid'];
		$title=$row1['title'];
		$featid=$row1['featid'];
		$page=$row1['page'];
		$authid=$row1['authid'];
		$volume=$row1['volume'];
		$part=$row1['part'];
		$year=$row1['year'];
		$month=$row1['month'];
		
		$title1=addslashes($title);
		
		$query3 = "select feat_name from feature where featid='$featid'";
		
				
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();
		
		$feature=$row3['feat_name'];
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
		if($feature != "")
		{
			echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"featurespan\"><a href=\"feat.php?feature=" . urlencode($feature) . "&amp;featid=$featid\">$feature</a></span>";
		}
		if($result3){$result3->free();}
		
		if($authid != 0)
		{

			echo "<br />&mdash;";
			$aut = preg_split('/;/',$authid);

			$fl = 0;
			foreach ($aut as $aid)
			{
				$query2 = "select * from author where authid=$aid";

								
				$result2 = $db->query($query2); 
				$num_rows2 = $result2 ? $result2->num_rows : 0;

				if($num_rows2 > 0)
				{
										$row2 = $result2->fetch_assoc();
					
					$authorname=$row2['authorname'];

					if($fl == 0)
					{
						echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
						$fl = 1;
					}
					else
					{
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"auth.php?authid=$aid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
					}
				}
				if($result2){$result2->free();}
			}
		}
		//~ echo "<br /><span class=\"downloadspan\"><a href=\"../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\" target=\"_blank\">View article</a>&nbsp;|&nbsp;<a href=\"#\">Download article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download article (PDF)</a></span>";
		echo "</li>\n";
	}
}
else
{
	echo "No data in the database";
}

if($result1){$result1->free();}
$db->close();

?>
				</ul>
			</div>
	</div>
    
<?php include("include_footer.php");?>

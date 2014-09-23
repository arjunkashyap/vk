<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vedanta Kesari | Digital archives of their Publications</title>
<link href="../style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="page">
	<div class="header">
		<div class="zsi_logo"><img src="../images/logo.png" alt="ZSI Logo" /></div>
		<div class="title">
			<p class="eng">
				<span class="big">Sri Ramakrishna Math</span><br />
				<span class="big">Mylapore, Chennai</span><br />
			</p>
		    <div class="full">
				<p class="vbig">The Vedanta Kesari</p>
				<p class="small">Lion of Vedanta</p>
			</div> 
		</div>
<?php include("include_nav.php");?>
	</div>
	<div class="mainpage">
		<div class="nav">
			<ul class="menu">
				<li class="gap_below"><a href="../search.php"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</a></li>
				<li><a href="volumes.php"><i class="fa fa-book"></i>&nbsp;&nbsp;Volumes</a></li>
				<li><a href="articles.php"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Articles</a></li>
				<li><a href="authors.php"><i class="fa fa-user"></i>&nbsp;&nbsp;Authors</a></li>
				<li><a href="features.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
			</ul>
			<div class="motif">
				<img src="../images/motif.jpg">
			</div>
		</div>
		<div class="archive_holder_volume">
<?php

include("connect.php");
require_once("../common.php");

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

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

echo "<div class=\"page_title\"><i class='fa fa-book fa-1x'></i>&nbsp;&nbsp;".$year."&nbsp;&nbsp;(Volume".intval($volume).")</div>";
?>

			<div class="col1">
				<ul>

<?php

$row_count = 4;
$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct part from article where volume='$volume' order by part";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$count = 0;
$col = 1;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
		$row = $result->fetch_assoc();
		
		$part=$row['part'];
		
		$query11 = "select min(page) as minpage from article where volume='$volume' and part='$part'";
		
		//~ $result11 = mysql_query($query11);
		//~ $num_rows11 = mysql_num_rows($result11);
		$result11 = $db->query($query11); 
		$num_rows11 = $result11 ? $result11->num_rows : 0;

		
		if($num_rows11 > 0)
		{
			//~ $row11=mysql_fetch_assoc($result11);
			$row11 = $result11->fetch_assoc();
			$page_start = $row11['minpage'];
			$page_start = intval($page_start);
		}
		if($result11){$result11->free();}

		$query12 = "select max(page_end) as maxpage from article where volume='$volume' and part='$part'";
		
		//~ $result12 = mysql_query($query12);
		//~ $num_rows12 = mysql_num_rows($result12);
		$result12 = $db->query($query12); 
		$num_rows12 = $result12 ? $result12->num_rows : 0;
		
		if($num_rows12 > 0)
		{
			//~ $row12=mysql_fetch_assoc($result12);
			$row12 = $result12->fetch_assoc();
			$page_end = $row12['maxpage'];
			$page_end = intval($page_end);
		}
		if($result12){$result12->free();}

		$query1 = "select distinct month from article where volume='$volume' and part='$part' order by month";

		//~ $result1 = mysql_query($query1);
		//~ $num_rows1 = mysql_num_rows($result1);
		$result1 = $db->query($query1); 
		$num_rows1 = $result1 ? $result1->num_rows : 0;

		if($num_rows1 > 0)
		{
			//~ $row1=mysql_fetch_assoc($result1);
			$row1 = $result1->fetch_assoc();
			$month = $row1['month'];

			$count++;
			if($count > $row_count)
			{
				$col++;
				echo "</div>\n
				<div class=\"col$col\">";
				echo "<ul>";
				$count = 1;
			}
			
			$dpart = preg_replace("/^0/", "", $part);
			$dpart = preg_replace("/\-0/", "-", $dpart);
			
			echo "<li class=\"li_below\"><span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;part=$part\">Issue&nbsp;".$dpart;
			if(intval($month) != 0)
			{
				echo "&nbsp;(".$month_name{intval($month)}.")";
			}
			echo "<br /></a></span></li>";
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
	<div class="footer">
		<div class="foot_links">
			<div class="foot_links1">
				<ul>
					<li class="foot_link_span"><a href="index.php">‣Home</a></li>
					<li class="foot_link_span"><a href="../about1.php">‣About</a></li>
					<li class="foot_link_span"><a href="records/volumes.php">‣Digital Archives</a></li>
				</ul>
			</div>
			<div class="foot_right">
				<span class="big">Sri Ramakrishna Math</span>
				<p>	31 Ramakrishna Math Road,<br>
					Mylapore, Chennai 600004,India<br>
					Email: mail@chennaimath.org<br>
					<i class="fa fa-phone-square"></i>&nbsp; 044-24621110<br>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="foot_box">
	<div class="left">
		&copy;The Vedanta Kesari, Sri Ramakrishna Math, Mylapore, Chennai.
	</div>
	<div class="right">All Rights Reserved</div>
</div>
</body>

</html>


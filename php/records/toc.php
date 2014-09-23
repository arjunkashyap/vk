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
		<div class="archive_holder">
<?php

include("connect.php");
require_once("../common.php");

if(isset($_GET['vol'])){$volume = $_GET['vol'];}else{$volume = '';}
if(isset($_GET['part'])){$part = $_GET['part'];}else{$part = '';}

if(!(isValidVolume($volume) && isValidPart($part)))
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

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

$query = "select distinct year,month from article where volume='$volume' and part='$part'";

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	//~ $row=mysql_fetch_assoc($result);
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

//~ $result1 = mysql_query($query1);
//~ $num_rows1 = mysql_num_rows($result1);

if($num_rows1 > 0)
{
	for($i=1;$i<=$num_rows1;$i++)
	{
		//~ $row1=mysql_fetch_assoc($result1);
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
		
		//~ $result3 = mysql_query($query3);		
		//~ $row3=mysql_fetch_assoc($result3);

		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();
		
		$feature=$row3['feat_name'];
		
		echo "<li>";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
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

				//~ $result2 = mysql_query($query2);
				//~ $num_rows2 = mysql_num_rows($result2);

				$result2 = $db->query($query2); 
				$num_rows2 = $result2 ? $result2->num_rows : 0;

				if($num_rows2 > 0)
				{
					//~ $row2=mysql_fetch_assoc($result2);
					$row2 = $result2->fetch_assoc();
					
					$authorname=$row2['authorname'];

					if($fl == 0)
					{
						echo "<span class=\"authorspan\"><a href=\"../auth.php?authid=$aid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
						$fl = 1;
					}
					else
					{
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"../auth.php?authid=$aid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
					}
				}
				if($result2){$result2->free();}
			}
		}
		//~ echo "<br /><span class=\"downloadspan\"><a href=\"../../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\" target=\"_blank\">View article</a>&nbsp;|&nbsp;<a href=\"#\">Download article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download article (PDF)</a></span>";
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
	<div class="right">
		&copy;The Vedanta Kesari, Sri Ramakrishna Math, Mylapore, Chennai. All Rights Reserved
	</div>
</div>
</body>

</html>

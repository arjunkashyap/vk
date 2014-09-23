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
			<div class="page_title"><i class="fa fa-tags"></i>&nbsp;&nbsp;Categories</div>
				<ul class="dot">
<?php

include("connect.php");

$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo '<li>Not connected to the database [' . $db->connect_errno . ']</li>';
	echo "</ul></div></div>";
	include("include_footer.php");
	echo "<div class=\"clearfix\"></div></div>";
	include("include_footer_out.php");
	echo "</body></html>";
	exit(1);
}

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

$query = "select * from feature order by feat_name";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
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

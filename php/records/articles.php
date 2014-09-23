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
			<div class="page_title"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Articles</div>
			<div class="alphabet">
				<span class="letter"><a href="articles.php?letter=A">A</a></span>
				<span class="letter"><a href="articles.php?letter=B">B</a></span>
				<span class="letter"><a href="articles.php?letter=C">C</a></span>
				<span class="letter"><a href="articles.php?letter=D">D</a></span>
				<span class="letter"><a href="articles.php?letter=E">E</a></span>
				<span class="letter"><a href="articles.php?letter=F">F</a></span>
				<span class="letter"><a href="articles.php?letter=G">G</a></span>
				<span class="letter"><a href="articles.php?letter=H">H</a></span>
				<span class="letter"><a href="articles.php?letter=I">I</a></span>
				<span class="letter"><a href="articles.php?letter=J">J</a></span>
				<span class="letter"><a href="articles.php?letter=K">K</a></span>
				<span class="letter"><a href="articles.php?letter=L">L</a></span>
				<span class="letter"><a href="articles.php?letter=M">M</a></span>
				<span class="letter"><a href="articles.php?letter=N">N</a></span>
				<span class="letter"><a href="articles.php?letter=O">O</a></span>
				<span class="letter"><a href="articles.php?letter=P">P</a></span>
				<span class="letter"><a href="articles.php?letter=Q">Q</a></span>
				<span class="letter"><a href="articles.php?letter=R">R</a></span>
				<span class="letter"><a href="articles.php?letter=S">S</a></span>
				<span class="letter"><a href="articles.php?letter=T">T</a></span>
				<span class="letter"><a href="articles.php?letter=U">U</a></span>
				<span class="letter"><a href="articles.php?letter=V">V</a></span>
				<span class="letter"><a href="articles.php?letter=W">W</a></span>
				<span class="letter"><a href="articles.php?letter=X">X</a></span>
				<span class="letter"><a href="articles.php?letter=Y">Y</a></span>
				<span class="letter"><a href="articles.php?letter=Z">Z</a></span>
				<span class="letter"><a href="articles.php?letter=Special">#</a></span>
			</div>
				<ul class="dot">
<?php

include("connect.php");
require_once("../common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];
	
	if(!(isValidLetter($letter)))
	{
		echo "<li>Invalid URL</li>";
		
		echo "</ul></div></div>";
		include("include_footer.php");
		echo "<div class=\"clearfix\"></div></div>";
		include("include_footer_out.php");
		echo "</body></html>";
		exit(1);
	}
	
	if($letter == '')
	{
		$letter = 'A';
	}
}
else
{
	$letter = 'A';
}

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

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

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

if($letter == 'Special')
{
	$query = "select * from article where title not regexp '^[a-zA-Z].*' order by title, volume, part, page";
}
else
{
	$query = "select * from article where title like '$letter%' order by title, volume, part, page";
}

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
		$row = $result->fetch_assoc();
		
		$titleid=$row['titleid'];
		$title=$row['title'];
		$featid=$row['featid'];
		$page=$row['page'];
		$authid=$row['authid'];
		$volume=$row['volume'];
		$part=$row['part'];
		$year=$row['year'];
		$month=$row['month'];
		
		$title1=addslashes($title);
		
		$query3 = "select feat_name from feature where featid='$featid'";
		
		$result3 = $db->query($query3); 
		//~ $result3 = mysql_query($query3);	
			
		//~ $row3=mysql_fetch_assoc($result3);		
		$row3 = $result3->fetch_assoc();		
		$feature=$row3['feat_name'];
		$dpart = preg_replace("/^0/", "", $part);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		
		if($result3){$result3->free();}
				
		echo "<li>";
		echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
		echo "
		<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
		<span class=\"yearspan\">
			<a href=\"toc.php?vol=$volume&amp;part=$part\">".$year."&nbsp;&nbsp;" . $month_name{intval($month)}."&nbsp;;&nbsp;(Volume&nbsp;".intval($volume)."&nbsp;&nbsp;Issue&nbsp;".$dpart.")</a>
		</span>";
		if($feature != "")
		{
			echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"featurespan\"><a href=\"feat.php?feature=" . urlencode($feature) . "&amp;featid=$featid\">$feature</a></span>";
		}
		
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
	echo "<li>Sorry! No articles were found to begin with the letter '$letter' in Records of the The Vedanta Kesari</li>";
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
	<div class="right">
		&copy;The Vedanta Kesari, Sri Ramakrishna Math, Mylapore, Chennai. All Rights Reserved
	</div>
</div>
</body>

</html>

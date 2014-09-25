<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vedanta Kesari | Digital archives of their Publications</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="page">
	<div class="header">
		<div class="zsi_logo"><img src="images/logo.png" alt="Ramakrishna Math Logo" /></div>
		<div class="title">
			<p class="eng">
				<span class="big">Sri Ramakrishna Math,</span><br />
				<span class="big">Mylapore, Chennai</span><br />
			</p>
		    <div class="full">
				<p class="vbig">The Vedanta Kesari</p>
				<p class="small">Lion of Vedanta</p>
			</div> 
		</div>
<?php include("include_nav.php");
include("connect.php");
require_once("common.php");

if(isset($_GET['authid'])){$authid = $_GET['authid'];}else{$authid = '';}
if(isset($_GET['author'])){$authorname = $_GET['author'];}else{$authorname = '';}

$authorname = entityReferenceReplace($authorname);
?>
	</div>
	<div class="mainpage">
		<div class="nav">
			<ul class="menu">
				<li class="gap_below"><a href="search.php"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</a></li>
				<li><a href="volumes.php"><i class="fa fa-book"></i>&nbsp;&nbsp;Volumes</a></li>
				<li><a href="articles.php"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Articles</a></li>
				<li><a href="authors.php"><i class="fa fa-user"></i>&nbsp;&nbsp;Authors</a></li>
				<li><a href="features.php"><i class="fa fa-tags"></i>&nbsp;Categories</a></li>
			</ul>
			<div class="motif">
				<img src="images/motif.jpg">
			</div>
		</div>
		<div class="archive_holder">
		<?php echo "<div class=\"page_title\"><i class=\"fa fa-user fa-1x\"></i>&nbsp;&nbsp;Articles written by $authorname</div>";?>
			<ul class="dot">
<?php

//~ include("connect.php");
//~ require_once("common.php");
//~ 
//~ if(isset($_GET['authid'])){$authid = $_GET['authid'];}else{$authid = '';}
//~ if(isset($_GET['author'])){$authorname = $_GET['author'];}else{$authorname = '';}
//~ 
//~ $authorname = entityReferenceReplace($authorname);
if(!(isValidAuthid($authid) && isValidAuthor($authorname)))
{
	echo "Invalid URL";
	
	echo "</div></div>";
	include("include_footer.php");
	echo "<div class=\"clearfix\"></div></div>";
	include("include_footer_out.php");
	echo "</body></html>";
	exit(1);
}

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

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

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");



$query = "(select titleid, title, page from article where authid like '%$authid%')";
//~ UNION ALL (select 'type', titleid, title, page from article_memoirs where authid like '%$authid%') 
//~ UNION ALL (select 'type', titleid, title, page from article_occpapers where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from fbi_books_list where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from sfs_book_toc where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from cas_book_toc where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from ess_book_toc where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from hpg_books_list where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from spb_book_toc where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from sse_books_list where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from tcm_books_list where authid like '%$authid%') 
//~ UNION ALL (select type, book_id, title, page from zlg_book_toc where authid like '%$authid%')
//~ UNION ALL (select 'type', titleid, title, page from article_bulletin where authid like '%$authid%')";

//~ echo $query;

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

		//~ $type=$row['type'];
		$book_id=$row['titleid'];
		$title=$row['title'];
		$page=$row['page'];
		
		$title = preg_replace('/!!(.*)!!/', "<i>$1</i>", $title);
		$title = preg_replace('/!/', "", $title);
		$type = 1;
		$query_aux = "select * from article where titleid='$book_id'";
			
			//~ $result_aux = mysql_query($query_aux);
			$result_aux = $db->query($query_aux); 
			//~ $row_aux=mysql_fetch_assoc($result_aux);
			$row_aux = $result_aux->fetch_assoc();

			$titleid=$row_aux['titleid'];
			$title=$row_aux['title'];
			$featid=$row_aux['featid'];
			$page=$row_aux['page'];
			$authid=$row_aux['authid'];
			$volume=$row_aux['volume'];
			$part=$row_aux['part'];
			$year=$row_aux['year'];
			$month=$row_aux['month'];
			
			if($result_aux){$result_aux->free();}
			
			$paper = $volume;	
			$title1=addslashes($title);
					
			$query3 = "select feat_name from feature where featid='$featid'";
			
			//~ $result3 = mysql_query($query3);		
			//~ $row3=mysql_fetch_assoc($result3);
			
			$result3 = $db->query($query3); 
			$row3 = $result3->fetch_assoc();
			
			$dpart = preg_replace("/^0/", "", $part);
			$dpart = preg_replace("/\-0/", "-", $dpart);
			$feature=$row3['feat_name'];
			
			if($result3){$result3->free();}
					
				echo "<li>";
				echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
				echo "<br /><span class=\"featurespan\">
					<a href=\"toc.php?vol=$volume&amp;part=$part\">".$year."&nbsp" . $month_name{intval($month)}."&nbsp;;&nbsp;(Volume&nbsp;".intval($volume)."&nbsp;&nbsp;Issue&nbsp;".$dpart.")</a>
				</span>";
				if($feature != "")
				{
					echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"featurespan\"><a href=\"feat.php?feature=" . urlencode($feature) . "&amp;featid=$featid\">$feature</a></span>";
				}
				
				//~ echo "<br /><span class=\"downloadspan\"><a href=\"Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\" target=\"_blank\">View article</a>&nbsp;|&nbsp;<a href=\"#\">Download article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download article (PDF)</a></span>";
				echo "</li>\n";
			
			
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

</body>

</html>

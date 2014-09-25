<?php
	// If nothing is GETed, redirect to search page
	if(empty($_GET['author']) && empty($_GET['title']) && empty($_GET['text'])) {
		header('Location: search.php');
		exit(1);
	}
?>
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
<?php include("include_nav.php");?>
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
			<ul class="dot">
<?php

include("connect.php");
require_once("common.php");

$db = @new mysqli('localhost', $user, $password, $database);
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

	if(isset($_GET['author'])){$author = $_GET['author'];}else{$author = '';}
	if(isset($_GET['text'])){$text = $_GET['text'];}else{$text = '';}
	if(isset($_GET['title'])){$title = $_GET['title'];}else{$title = '';}
		
	$text = entityReferenceReplace($text);
	$author = entityReferenceReplace($author);
	$title = entityReferenceReplace($title);
	
	$author = preg_replace("/[\t]+/", " ", $author);
	$author = preg_replace("/[ ]+/", " ", $author);
	$author = preg_replace("/^ /", "", $author);

	$title = preg_replace("/[\t]+/", " ", $title);
	$title = preg_replace("/[ ]+/", " ", $title);
	$title = preg_replace("/^ /", "", $title);

	$text = preg_replace("/[\t]+/", " ", $text);
	$text = preg_replace("/[ ]+/", " ", $text);
	$text = preg_replace("/^ /", "", $text);

	$text2 = $text;
	$text2d = $text;
	$text2d = preg_replace("/ /", "|", $text2d);
	$dtext='';

	if($title=='')
	{
		$title='[a-z]*';
	}
	if($author=='')
	{
		$author='[a-z]*';
	}

	$cfl = 0;
	
	$author = addslashes($author);
	$title = addslashes($title);
	
	if($text=='')
	{
		$query="SELECT * FROM
                    (SELECT * FROM article WHERE authorname regexp '$author') AS tb1
                            WHERE title regexp '$title' ORDER BY authid DESC";
	}
	elseif($text!='')
	{
		$text = trim($text);
		if(preg_match("/^\"/", $text))
		{
			$stext = preg_replace("/\"/", "", $text);
			$dtext = $stext;
			$stext = '"' . $stext . '"';
		}
		elseif(preg_match("/\+/", $text))
		{
			$stext = preg_replace("/\+/", " +", $text);
			$dtext = preg_replace("/\+/", "|", $text);
			$stext = '+' . $stext;
		}
		elseif(preg_match("/\|/", $text))
		{
			$stext = preg_replace("/\|/", " ", $text);
			$dtext = $text;
		}
		else
		{
			$stext = $text;
			$dtext = $stext = preg_replace("/ /", "|", $text);
		}
		
		$stext = addslashes($stext);
		
		$query="SELECT * FROM
						(SELECT * FROM
							(SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$text' IN BOOLEAN MODE))
						AS tb1 WHERE authorname REGEXP '$author')
					AS tb2 WHERE title REGEXP '$title' ORDER BY volume, part, cur_page";
						
	}
	$result = $db->query($query); 
	$num_results = $result ? $result->num_rows : 0;

	if ($num_results > 0)
	{
		echo "<div class=\"count authorspan\">$num_results result(s)</div>";
	}
	echo "<div class=\"page_title\">Search Results</div>";
	$titleid[0]=0;
	$count = 1;
	$id = "0";
	if($num_results > 0)
	{
		echo "<ul>";
		for($i=1;$i<=$num_results;$i++)
		{
			//~ $row1 = mysql_fetch_assoc($result);
			$row1 = $result->fetch_assoc();

			$titleid = $row1['titleid'];
			$authid = $row1['authid'];
			$authorname = $row1['authorname'];
			$featid = $row1['featid'];
			$title = $row1['title'];
			$volume = $row1['volume'];
			$authid = $row1['authid'];
			$authorname = $row1['authorname'];
			$page = $row1['page'];
			$part = $row1['part'];
			$month = $row1['month'];
			$year = $row1['year'];
			$dpart = preg_replace("/^0/", "", $part);
			$dpart = preg_replace("/\-0/", "-", $dpart);
			
			if($text != '')
			{
				$cur_page = $row1['cur_page'];
			}
			
			$title1=addslashes($title);
			//~ echo "<li>";
			//~ echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"show_article.php?volume=$volume&issue=$part&titleid=$titleid&page=$page\">$title</a></span><br/>";
			//~ echo "<span class=\"downloadspan\">&nbsp;&nbsp;&nbsp;&nbsp;<a title=\"Download Article\" href=\"Downloads/download_djvu.php?titleid=$titleid\" target=\"_blank\">DjVu</a></span><br/></li>";
			echo "<li>";
			echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page&amp;find=$dtext/r\">$title</a></span>";
			echo "
			<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
			<span class=\"yearspan\">
			<a href=\"toc.php?vol=$volume&amp;part=$part\">".$year."&nbsp;&nbsp;" . $month_name{intval($month)}."&nbsp;;&nbsp;(Volume&nbsp;".intval($volume)."&nbsp;&nbsp;Issue&nbsp;".$dpart.")</a>
			</span>";
			

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
						echo "<span class=\"titlespan\">;&nbsp;</span><span class=\"authorspan\"><a href=\"php/auth.php?authid=$aid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
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
		echo"<span class=\"titlespan\">No results</span><br />";
		echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and Search again</a></span>";
	}	
	if($result){$result->free();}

else
{
	echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and Search again</a></span>";
}
$db->close();
?>
		
		</div>
	</div>
    
<?php include("include_footer.php");?>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vedanta Kesari | Digital archives of their Publications</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="page">
	<div class="header">
		<div class="zsi_logo"><img src="images/logo.png" alt="ZSI Logo" /></div>
		<div class="title">
			<p class="eng">
				<span class="big">Sri Chennai Math,</span><br />
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
				<li><a href="records/volumes.php" class="active">Volumes</a></li>
				<li><a href="records/articles.php">Articles</a></li>
				<li><a href="records/authors.php">Authors</a></li>
				<li><a href="records/features.php">Categories</a></li>
				<li class="gap_below"><a href="../search.php">Search</a></li>
				<li><a title="Click to download DjVu plugin" href="https://www.cuminas.jp/en/downloads/download_en/?pid=1" target="_blank">Get DjVu</a></li>
			</ul>
		</div>
		<div class="archive_holder">
<?php

include("records/connect.php");
require_once("common.php");

if(isset($_GET['authid'])){$authid = $_GET['authid'];}else{$authid = '';}
if(isset($_GET['author'])){$authorname = $_GET['author'];}else{$authorname = '';}

$authorname = entityReferenceReplace($authorname);

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

echo "<div class=\"page_title\">Bibliography of $authorname</div>";
echo "<ul>";

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
		if(($type == "fbi") || ($type == "fi") || ($type == "hpg") || ($type == "sse") || ($type == "tcm"))
		{
			if($type == "fi")
			{
				$query_aux = "select * from fbi_books_list where book_id=$book_id and type='".$type."'";
			}
			else
			{	
				$query_aux = "select * from ".$type."_books_list where book_id=$book_id and type='".$type."'";
			}
			//~ $query_aux = "select * from ".$type."_books_list where book_id=$book_id and type='".$type."'";
			//~ $result_aux = mysql_query($query_aux);
			//~ $num_rows_aux = mysql_num_rows($result_aux);
			
			$result_aux = $db->query($query_aux); 
			$num_rows_aux = $result_aux ? $result_aux->num_rows : 0;

			//~ $row_aux=mysql_fetch_assoc($result_aux);
			$row_aux = $result_aux->fetch_assoc();
			
			$authid=$row_aux['authid'];
			$authorname=$row_aux['authorname'];
			$type=$row_aux['type'];
			$page=$row_aux['page'];
			
			$page_end=$row_aux['page_end'];
			$edition=$row_aux['edition'];
			$volume=$row_aux['volume'];
			$part=$row_aux['part'];
			$year=$row_aux['year'];
			$month=$row_aux['month'];
			$book_id=$row_aux['book_id'];
			
			if($result_aux){$result_aux->free();}
			
			$book_info = '';

			//~ if($type == 'fbi')
			//~ {
				//~ $book_info = $book_info . "Fauna of British India ";	
			//~ }
			//~ elseif($type == 'fi')
			//~ {
				//~ $book_info = $book_info . "Fauna of India ";	
			//~ }
			//~ elseif($type == 'hpg')
			//~ {
				//~ $book_info = $book_info . "Handbook and Pictorial Guides ";	
			//~ }
			//~ elseif($type == 'sse')
			//~ {
				//~ $book_info = $book_info . "Status Survey of Endangered Species ";	
			//~ }
			//~ elseif($type == 'tcm')
			//~ {
				//~ $book_info = $book_info . "Technical Monographs ";	
			//~ }
//~ 
			//~ if($edition != '00')
			//~ {
				//~ if (intval($edition) == 1)
				//~ {
					//~ $book_info = $book_info . " | First Edition";
				//~ }
				//~ if (intval($edition) == 2)
				//~ {
					//~ $book_info = $book_info . " | Second Edition";
				//~ }
			//~ }
			if($volume != '00')
			{
				$book_info = $book_info . " | Volume " . intval($volume);
			}
			if($part != '00')
			{
				$book_info = $book_info . " | Part " . intval($part);
			}
			if(intval($page) != 0)
			{
				$book_info = $book_info . " | pp " . intval($page) . " - " . intval($page_end);	
			}
			
			echo "<li><span class=\"motif ".$type."_motif\"></span>";
			echo "<span class=\"titlespan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($title) . "\">$title</a></span>";
			echo "<br /><span class=\"bookspan\">$book_info</span>";
			echo "<br /><span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($title) . "\">View TOC</a>&nbsp;|&nbsp;<a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">Read Book</a>&nbsp;|&nbsp;<a href=\"\" target=\"_blank\">Download Book (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download Book (PDF)</a></span>";
			echo "</li>\n";
		}
		elseif(($type == "sfs") || ($type == "cas") || ($type == "ess") || ($type == "spb") || ($type == "zlg"))
		{
			$book_info = "";
			
			$query_aux = "select * from ".$type."_books_list where book_id=$book_id and type='".$type."'";
			
			//~ $result_aux = mysql_query($query_aux);
			//~ $num_rows_aux = mysql_num_rows($result_aux);			
			//~ $row_aux=mysql_fetch_assoc($result_aux);

			$result_aux = $db->query($query_aux); 
			$num_rows_aux = $result_aux ? $result_aux->num_rows : 0;
			$row_aux = $result_aux->fetch_assoc();
			
			$authid=$row_aux['authid'];
			$authorname=$row_aux['authorname'];
			
			$btitle = $row_aux['title'];
			$slno = $row_aux['slno'];
			$edition = $row_aux['edition'];
			$volume = $row_aux['volume'];
			$part = $row_aux['part'];
			$dpage = $row_aux['page'];
			$dpage_end = $row_aux['page_end'];
			$month = $row_aux['month'];
			$year = $row_aux['year'];

			if($result_aux){$result_aux->free();}

			if($type == 'sfs')
			{
				$stitle = "State Fauna Series ";	
			}
			elseif($type == 'cas')
			{
				$stitle = "Conservation Area Series ";	
			}
			elseif($type == 'ess')
			{
				$stitle = "Ecosystem Series ";	
			}
			elseif($type == 'spb')
			{
				$stitle = "Special Publications ";	
			}
			elseif($type == 'zlg')
			{
				$stitle = "Zoologiana ";	
			}
			
			if($btitle != '')
			{
				$book_info = $book_info . " | " . $btitle;
			}
			if($edition != '00')
			{
				$book_info = $book_info . " | Edition " . intval($edition);
			}
			if($volume != '00')
			{
				$book_info = $book_info . " | Volume " . intval($volume);
			}
			if($part != '00')
			{
				$book_info = $book_info . " | Part " . intval($part);
			}
			if(intval($dpage) != 0)
			{
				$book_info = $book_info . " | pp " . intval($dpage) . " - " . intval($dpage_end);	
			}
			if(intval($month) != 0)
			{
				$book_info = $book_info . " | " . $month_name{intval($month)} . " " . intval($year);	
			}

			$book_info = preg_replace("/^ /", "", $book_info);
			$book_info = preg_replace("/^\|/", "", $book_info);
			$book_info = preg_replace("/^ /", "", $book_info);

			echo "<li><span class=\"motif ".$type."_motif\"></span>";
			echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$book_id/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
			echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"yearspan\">$stitle</span><br /><span class=\"bookspan\">$book_info</span>";
			echo "<br /><span class=\"downloadspan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($btitle) . "\">View TOC</a>&nbsp;|&nbsp;<a href=\"\" target=\"_blank\">Download Article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download Article (PDF)</a></span>";
			echo "</li>\n";
		}
		elseif(($type == "type"))
		{
			$titleid = $book_id;

			if(preg_match("/^rec/", $book_id))
			{
				$type = "records";
				$dtype = "Records";
			}
			elseif(preg_match("/^mem/", $book_id))
			{
				$type = "memoirs";
				$dtype = "Memoirs";
			}
			elseif(preg_match("/^occ/", $book_id))
			{
				$type = "occpapers";
				$dtype = "Occasional Papers";
			}
			elseif(preg_match("/^bul/", $book_id))
			{
				$type = "bulletin";
				$dtype = "Bulletin";
			}
						
			$query_aux = "select * from article_".$type." where titleid='$titleid'";
			
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
					
			$query3 = "select feat_name from feature_".$type." where featid='$featid'";
			
			//~ $result3 = mysql_query($query3);		
			//~ $row3=mysql_fetch_assoc($result3);
			
			$result3 = $db->query($query3); 
			$row3 = $result3->fetch_assoc();
			
			$feature=$row3['feat_name'];
			
			if($result3){$result3->free();}
					
			if(($type == "records") || ($type == "memoirs") || ($type == "bulletin"))
			{
				echo "<li><span class=\"motif ".$type."_motif\"></span>";
				echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\">$title</a></span>";
				echo "<br /><span class=\"featurespan\">$dtype&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href=\"$type/toc.php?vol=$volume&amp;part=$part\">Vol.&nbsp;".intval($volume)."&nbsp;(p. ".$part.")&nbsp;;&nbsp;" . $month_name{intval($month)}."&nbsp;".$year."</a>
				</span>";
				if($feature != "")
				{
					echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"featurespan\"><a href=\"$type/feat.php?feature=" . urlencode($feature) . "&amp;featid=$featid\">$feature</a></span>";
				}
				
				echo "<br /><span class=\"downloadspan\"><a href=\"../Volumes/$type/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page\" target=\"_blank\">View article</a>&nbsp;|&nbsp;<a href=\"#\">Download article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download article (PDF)</a></span>";
				echo "</li>\n";
			}
			elseif($type == "occpapers")
			{
				echo "<li><span class=\"motif ".$type."_motif\"></span>";
				echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/occpapers/$paper/index.djvu?djvuopts&amp;page=1&amp;zoom=page\">$title</a></span>";
				echo "<span class=\"featurespan\"><br />Occ. paper no.&nbsp;".intval($paper)."&nbsp;($year)</span>";
				echo "<br /><span class=\"downloadspan\"><a href=\"../Volumes/occpapers/$paper/index.djvu?djvuopts&amp;page=1&amp;zoom=page\" target=\"_blank\">View article</a>&nbsp;|&nbsp;<a href=\"#\">Download article (DjVu)</a>&nbsp;|&nbsp;<a href=\"#\">Download article (PDF)</a></span>";
				echo "</li>\n";
			}
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
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="foot_box">
	<div class="left">
		&copy;The Vedanta Kesari, chennai Math, Chennai. All Rights Reserved
	</div>
	<div class="right">
		<ul>
			<li><a href="php/contact.php">Contact us</a></li>
		</ul>
	</div>
</div>
</body>

</html>

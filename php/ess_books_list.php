<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zoological Survey of India | Digital archives of their Publications</title>
<link href="style/reset.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/indexstyle.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-2.0.0.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/treeview.js"></script>
</head>

<body>
<div class="page">
	<div class="header">
		<div class="zsi_logo"><img src="images/logo.png" alt="ZSI Logo" /></div>
		<div class="gov_logo"><img src="images/gov_logo.png" alt="Government of India Logo" /></div>
		<div class="title">
			<p class="eng">
				<span class="big">भारत सरकार</span><br />
				पर्यावरण एवं वन मंत्रालय<br />
				<span class="big">Government of India</span><br />
				Ministry of Environment and Forests
			</p>
			<div class="full">
				<p class="small">भारतीय प्राणी सर्वेक्षण</p>
				<p class="vbig">Zoological Survey of India</p>
			</div>
		</div>
<?php include("include_nav.php");?>
	</div>
	<div class="mainpage">
		<div class="nav">
			<div class="archive_title">Ecosystem Series</div>
			<ul class="menu">
				<li><a class="active" href="ess_books_list.php">Books</a></li>
				<li><a href="ess/authors.php">Authors</a></li>
				<li class="gap_below"><a href="search.php">Search</a></li>
				<li><a title="Click to download DjVu plugin" href="https://www.cuminas.jp/en/downloads/download_en/?pid=1" target="_blank">Get DjVu</a></li>
			</ul>
		</div>
		<div class="archive_holder">
			<div class="page_title"><span class="motif ess_motif"></span>Ecosystem Series</div>

<?php
include("ess/connect.php");

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

$query = "select * from ess_books_list order by slno";

//~ $result = mysql_query($query);
//~ $num_rows = mysql_num_rows($result);

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

$stack = array();
$p_stack = array();
$first = 1;

$li_id = 0;
$ul_id = 0;

$plus_link = "<img class=\"bpointer\" title=\"Expand\" src=\"images/plus.gif\" alt=\"Expand or Collapse\" onclick=\"display_block(this)\" />";
//$plus_link = "<a href=\"#\" onclick=\"display_block(this)\"><img src=\"plus.gif\" alt=\"\"></a>";
$bullet = "<img class=\"bpointer\" src=\"images/bullet_1.gif\" alt=\"Point\" />";

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

if($num_rows > 0)
{
	echo "<div class=\"treeview\">";
	for($i=1;$i<=$num_rows;$i++)
	{
		//~ $row=mysql_fetch_assoc($result);
		$row = $result->fetch_assoc();
				
		$book_id = $row['book_id'];
		$level = $row['level'];
		$title = $row['title'];
		$page = $row['page'];
		$page_end = $row['page_end'];
		$edition = $row['edition'];
		$volume = $row['volume'];
		$part = $row['part'];
		$type = $row['type'];
		$year = $row['year'];
		$month = $row['month'];

		$book_info = '';
		
		if($edition != '00')
		{
			if (intval($edition) == 1)
			{
				$book_info = $book_info . "First Edition";
			}
			if (intval($edition) == 2)
			{
				$book_info = $book_info . "Second Edition";
			}
		}
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
		if(intval($month) != 0)
		{
			$book_info = $book_info . " | " . $month_name{intval($month)} . " " . intval($year);
		}
		
		$book_info = preg_replace("/^ /", "", $book_info);
		$book_info = preg_replace("/^\|/", "", $book_info);
		$book_info = preg_replace("/^ /", "", $book_info);
			
		if($page != "")
		{
			// $title = preg_replace("/&amp;/", "%26", $title);
			
			$title = "<span class=\"titlespan\"><a href=\"".$type."/".$type."_books_toc.php?book_id=$book_id&amp;type=$type&amp;book_title=" . urlencode($title) . "\">$title</a></span>";
			$title = $title . "<br /><span class=\"space_left\"><span class=\"featurespan\">$book_info</span></span>";
		}
		else
		{
			$title = "<span class=\"titlespan\">$title</span>";
		}
				
		$title = preg_replace('/!!(.*)!!/', "<i>$1</i>", $title);
		$title = preg_replace('/---/', "&mdash;", $title);
		$title = preg_replace('/--/', "&ndash;", $title);
		
		if($first)
		{
			array_push($stack,$level);
			$ul_id++;
			echo "<ul id=\"ul_id$ul_id\">\n";
			array_push($p_stack,$ul_id);
			$li_id++;
			$deffer = display_tabs($level) . "<li id=\"li_id$li_id\">:rep:$title";
			$first = 0;
		}
		elseif($level > $stack[sizeof($stack)-1])
		{
			$deffer = preg_replace('/:rep:/',"$plus_link",$deffer);
			echo $deffer;			

			$ul_id++;			
			$li_id++;			
			array_push($stack,$level);
			array_push($p_stack,$ul_id);
			$deffer = "\n" . display_tabs(($level-1)) . "<ul class=\"dnone\" id=\"ul_id$ul_id\">\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
		elseif($level < $stack[sizeof($stack)-1])
		{
			$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
			echo $deffer;
			
			for($k=sizeof($stack)-1;(($k>=0) && ($level != $stack[$k]));$k--)
			{
				echo "</li>\n". display_tabs($level) ."</ul>\n";
				$top = array_pop($stack);
				$top1 = array_pop($p_stack);
			}
			$li_id++;
			$deffer = display_tabs($level) . "</li>\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
		elseif($level == $stack[sizeof($stack)-1])
		{
			$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
			echo $deffer;
			$li_id++;
			$deffer = "</li>\n";
			$deffer = $deffer . display_tabs($level) ."<li id=\"li_id$li_id\">:rep:$title";
		}
	}

	$deffer = preg_replace('/:rep:/',"$bullet",$deffer);
	echo $deffer;

	for($i=0;$i<sizeof($stack);$i++)
	{
		echo "</li>\n". display_tabs($level) ."</ul>\n";
	}

	echo "</div>";
}
else
{
	echo "No data in the database";
}

if($result){$result->free();}
$db->close();

function display_stack($stack)
{
	for($j=0;$j<sizeof($stack);$j++)
	{
		$disp_array = $disp_array . $stack[$j] . ",";
	}
	return $disp_array;
}

function display_tabs($num)
{
	$str_tabs = "";
	
	if($num != 0)
	{
		for($tab=1;$tab<=$num;$tab++)
		{
			$str_tabs = $str_tabs . "\t";
		}
	}
	
	return $str_tabs;
}

?>
			
		</div>
	</div>
<?php include("include_footer.php");?>
	<div class="clearfix"></div>
</div>
<?php include("include_footer_out.php");?>
</body>

</html>

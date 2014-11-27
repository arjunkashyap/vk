<?php include("include_header.php");?>
<?php include("include_nav.php");?>
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
	exit(1);
}

$month_name = array("0"=>"","1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");

if(isset($_GET['author'])){$author = $_GET['author'];}else{$author = '';}
if(isset($_GET['text'])){$text = $_GET['text'];}else{$text = '';}
if(isset($_GET['title'])){$title = $_GET['title'];}else{$title = '';}
if(isset($_GET['featid'])){$featid = $_GET['featid'];}else{$featid = '';}
if(isset($_GET['year1'])){$year1 = $_GET['year1'];}else{$year1 = '';}
if(isset($_GET['year2'])){$year2 = $_GET['year2'];}else{$year2 = '';}

$text = entityReferenceReplace($text);
$author = entityReferenceReplace($author);
$title = entityReferenceReplace($title);
$featid = entityReferenceReplace($featid);
$year1 = entityReferenceReplace($year1);
$year2 = entityReferenceReplace($year2);

$author = preg_replace("/[,\-]+/", " ", $author);
$author = preg_replace("/[\t]+/", " ", $author);
$author = preg_replace("/[ ]+/", " ", $author);
$author = preg_replace("/^ +/", "", $author);
$author = preg_replace("/ +$/", "", $author);
$author = preg_replace("/  /", " ", $author);
$author = preg_replace("/  /", " ", $author);

$title = preg_replace("/[,\-]+/", " ", $title);
$title = preg_replace("/[\t]+/", " ", $title);
$title = preg_replace("/[ ]+/", " ", $title);
$title = preg_replace("/^ +/", "", $title);
$title = preg_replace("/ +$/", "", $title);
$title = preg_replace("/  /", " ", $title);
$title = preg_replace("/  /", " ", $title);

$text = preg_replace("/[,\-]+/", " ", $text);
$text = preg_replace("/[\t]+/", " ", $text);
$text = preg_replace("/[ ]+/", " ", $text);
$text = preg_replace("/^ +/", "", $text);
$text = preg_replace("/ +$/", "", $text);
$text = preg_replace("/  /", " ", $text);
$text = preg_replace("/  /", " ", $text);


$text2 = $text;
if($title=='')
{
	$title='[a-z]*';
}
if($author=='')
{
	$author='[a-z]*';
}
if($featid=='')
{
	$featid='[a-z]*';
}

($year1 == '') ? $year1 = 1914 : $year1 = $year1;
($year2 == '') ? $year2 = date('Y') : $year2 = $year2;

if($year2 < $year1)
{
	$tmp = $year1;
	$year1 = $year2;
	$year2 = $tmp;
}

$authorFilter = '';
$titleFilter = '';
$textFilter = '';
$textSearchBox = '';

$authors = preg_split("/ /", $author);
$titles = preg_split("/ /", $title);
$texts = preg_split("/ /", $text);

for($ic=0;$ic<sizeof($authors);$ic++)
{
	$authorFilter .= "and authorname REGEXP '" . $authors[$ic] . "' ";
}
for($ic=0;$ic<sizeof($titles);$ic++)
{
	$titleFilter .= "and title REGEXP '" . $titles[$ic] . "' ";
}
for($ic=0;$ic<sizeof($texts);$ic++)
{
	$textFilter .= "+" . $texts[$ic] . "* ";
	$textSearchBox .= "|" . $texts[$ic];
}

$authorFilter = preg_replace("/^and /", "", $authorFilter);
$titleFilter = preg_replace("/^and /", "", $titleFilter);
$titleFilter = preg_replace("/ $/", "", $titleFilter);
$textSearchBox = preg_replace("/^\|/", "", $textSearchBox);

if($text=='')
{
	$query="SELECT * FROM
				(SELECT * FROM
                    (SELECT * FROM
                        (SELECT * FROM article WHERE $authorFilter) AS tb1
                    WHERE $titleFilter) AS tb2
				WHERE featid REGEXP '$featid') AS tb3
			WHERE year between $year1 and $year2 ORDER BY volume, part, page";

}
elseif($text!='')
{
	$text = rtrim($text);
	
	$query="SELECT * FROM
				(SELECT * FROM
					(SELECT * FROM
                        (SELECT * FROM
                            (SELECT * FROM searchtable WHERE MATCH (text) AGAINST ('$textFilter' IN BOOLEAN MODE)) AS tb1
                        WHERE $authorFilter) AS tb2
                    WHERE $titleFilter) AS tb3
                WHERE featid REGEXP '$featid') AS tb4
            WHERE year between $year1 and $year2 ORDER BY volume, part, cur_page";
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
        
        $query3 = "select feat_name from feature where featid='$featid'";
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();		
		$feature=$row3['feat_name'];
        
        if($text != '')
        {
            $cur_page = $row1['cur_page'];
        }
        
        $title1=addslashes($title);
        
        if ((strcmp($id, $titleid)) != 0)
		{
            if($id == "0")
			{
				echo "\n\n\n<li>";
			}
			else
			{
				echo "\n\n\n\n\n</li>\n<li>";
			}
            
            echo "<span class=\"titlespan\"><a target=\"_blank\" href=\"../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$page.djvu&amp;zoom=page&amp;find=$textSearchBox/r\">$title</a></span>";
            echo "<span class=\"titlespan\">&nbsp;&nbsp;|&nbsp;&nbsp;</span><span class=\"yearspan\"><a href=\"toc.php?vol=$volume&amp;part=$part\">" . $month_name{intval($month)} ."&nbsp;" . $year ."&nbsp;&nbsp;(Volume&nbsp;".intval($volume).", Issue&nbsp;".$dpart.")</a></span>";
            
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
            
            if($text != '')
            {
                echo "<br /><span class=\"titlespan sml\">result(s) found in page(s) : </span>";
                echo "<span class=\"featurespan sml\"><a href=\"../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$textSearchBox/r\" target=\"_blank\">".intval($cur_page)."</a> </span>";
            }
			$id = $titleid;
        }
        else
        {
            if($text != '')
			{
				echo "&nbsp;<span class=\"featurespan sml\"><a href=\"../Volumes/$volume/$part/index.djvu?djvuopts&amp;page=$cur_page.djvu&amp;zoom=page&amp;find=$textSearchBox/r\" target=\"_blank\">".intval($cur_page)."</a> </span>";
			}
			$id = $titleid;
        }
    }   
}
else
{
    echo"<span class=\"titlespan\">No results</span><br />";
    echo"<span class=\"authorspan\"><a href=\"search.php\">Go back and Search again</a></span>";
}	
if($result){$result->free();}
$db->close();
?>
		
		</div>
	</div>
    
<?php include("include_footer.php");?>

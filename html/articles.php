<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
				<h1 class="clr1">Archive &gt; Titles</h1>
				<div class="alphabet gapBelowSmall gapAboveSmall">
					<span class="letter"><a href="articles_01.html">A</a></span>
					<span class="letter"><a href="articles_02.html">B</a></span>
					<span class="letter"><a href="articles_03.html">C</a></span>
					<span class="letter"><a href="articles_04.html">D</a></span>
					<span class="letter"><a href="articles_05.html">E</a></span>
					<span class="letter"><a href="articles_06.html">F</a></span>
					<span class="letter"><a href="articles_07.html">G</a></span>
					<span class="letter"><a href="articles_08.html">H</a></span>
					<span class="letter"><a href="articles_09.html">I</a></span>
					<span class="letter"><a href="articles_10.html">J</a></span>
					<span class="letter"><a href="articles_11.html">K</a></span>
					<span class="letter"><a href="articles_12.html">L</a></span>
					<span class="letter"><a href="articles_13.html">M</a></span>
					<span class="letter"><a href="articles_14.html">N</a></span>
					<span class="letter"><a href="articles_15.html">O</a></span>
					<span class="letter"><a href="articles_16.html">P</a></span>
					<span class="letter"><a href="articles_17.html">Q</a></span>
					<span class="letter"><a href="articles_18.html">R</a></span>
					<span class="letter"><a href="articles_19.html">S</a></span>
					<span class="letter"><a href="articles_20.html">T</a></span>
					<span class="letter"><a href="articles_21.html">U</a></span>
					<span class="letter"><a href="articles_22.html">V</a></span>
					<span class="letter"><a href="articles_23.html">W</a></span>
					<span class="letter"><a href="articles_24.html">X</a></span>
					<span class="letter"><a href="articles_25.html">Y</a></span>
					<span class="letter"><a href="articles_26.html">Z</a></span>
				</div>
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];
	
	if(!(isValidLetter($letter)))
	{
		echo '<span class="aFeature clr2">Invalid URL</span>';
		echo '</div> <!-- cd-container -->';
		echo '</div> <!-- cd-scrolling-bg -->';
		echo '</main> <!-- cd-main-content -->';
		include("include_footer.php");

        exit(1);
	}
	
	($letter == '') ? $letter = 'A' : $letter = $letter;
}
else
{
	$letter = 'A';
}

$query = 'select * from article where title like \'' . $letter . '%\' order by title, volume, part, page';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$query3 = 'select feat_name from feature where featid=\'' . $row['featid'] . '\'';
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();		
		
		$dpart = preg_replace("/^0/", "", $row['part']);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		
		if($result3){$result3->free();}

		echo '<div class="article">';
		echo '	<div class="gapBelowSmall">';
		echo ($row3['feat_name'] != '') ? '		<span class="aFeature clr2"><a href="feat_' . $row['featid'] . '.html">' . $row3['feat_name'] . '</a></span> | ' : '';
		echo '		<span class="aIssue clr5"><a href="toc_' . $row['volume'] . '_' . $row['part'] . '.html">' . getMonth($row['month']) . ' ' . $row['year'] . '  (Volume ' . intval($row['volume']) . ', Issue ' . $dpart . ')</a></span>';
		echo '	</div>';
		echo '	<span class="aTitle"><a target="_blank" href="../Volumes/' . $row['volume'] . '/' . $row['part'] . '/index.djvu?djvuopts&amp;page=' . $row['page'] . '.djvu&amp;zoom=page">' . $row['title'] . '</a></span><br />';
		if($row['authid'] != 0) {

			echo '	<span class="aAuthor itl">by ';
			$authids = preg_split('/;/',$row['authid']);
			$authornames = preg_split('/;/',$row['authorname']);
			$a=0;
			foreach ($authids as $aid) {

				echo '<a href="auth_' . $aid . '.html">' . $authornames[$a] . '</a> ';
				$a++;
			}
			
			echo '	</span>';
		}
		echo '</div>';
	}
}
else
{
	echo '<span class="sml">Sorry! No articles were found to begin with the letter \'' . $letter . '\' in The Vedanta Kesari</span>';
}

if($result){$result->free();}
$db->close();

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>

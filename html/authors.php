<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
				<h1 class="clr1">Archive &gt; Authors</h1>
				<div class="alphabet gapBelowSmall gapAboveSmall">
					<span class="letter"><a href="authors_01.html">A</a></span>
					<span class="letter"><a href="authors_02.html">B</a></span>
					<span class="letter"><a href="authors_03.html">C</a></span>
					<span class="letter"><a href="authors_04.html">D</a></span>
					<span class="letter"><a href="authors_05.html">E</a></span>
					<span class="letter"><a href="authors_06.html">F</a></span>
					<span class="letter"><a href="authors_07.html">G</a></span>
					<span class="letter"><a href="authors_08.html">H</a></span>
					<span class="letter"><a href="authors_09.html">I</a></span>
					<span class="letter"><a href="authors_10.html">J</a></span>
					<span class="letter"><a href="authors_11.html">K</a></span>
					<span class="letter"><a href="authors_12.html">L</a></span>
					<span class="letter"><a href="authors_13.html">M</a></span>
					<span class="letter"><a href="authors_14.html">N</a></span>
					<span class="letter"><a href="authors_15.html">O</a></span>
					<span class="letter"><a href="authors_16.html">P</a></span>
					<span class="letter"><a href="authors_17.html">Q</a></span>
					<span class="letter"><a href="authors_18.html">R</a></span>
					<span class="letter"><a href="authors_19.html">S</a></span>
					<span class="letter"><a href="authors_20.html">T</a></span>
					<span class="letter"><a href="authors_21.html">U</a></span>
					<span class="letter"><a href="authors_22.html">V</a></span>
					<span class="letter"><a href="authors_23.html">W</a></span>
					<span class="letter"><a href="authors_24.html">X</a></span>
					<span class="letter"><a href="authors_25.html">Y</a></span>
					<span class="letter"><a href="authors_26.html">Z</a></span>
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

$query = 'select * from author where authorname like \'' . $letter . '%\' order by authorname';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo '<div class="author">';
		echo '	<span class="aAuthor"><a href="auth_' . $row['authid'] . '.html">' . $row['authorname'] . '</a> ';
		echo '</div>';
	}
}
else
{
	echo '<span class="sml">Sorry! No author names were found to begin with the letter \'' . $letter . '\' in The Vedanta Kesari</span>';
}

if($result){$result->free();}
$db->close();

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>

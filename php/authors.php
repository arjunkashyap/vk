<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder">
			<div class="page_title"><i class="fa fa-user"></i>&nbsp;&nbsp;Authors</div>
			<div class="alphabet">
				<span class="letter"><a href="authors.php?letter=A">A</a></span>
				<span class="letter"><a href="authors.php?letter=B">B</a></span>
				<span class="letter"><a href="authors.php?letter=C">C</a></span>
				<span class="letter"><a href="authors.php?letter=D">D</a></span>
				<span class="letter"><a href="authors.php?letter=E">E</a></span>
				<span class="letter"><a href="authors.php?letter=F">F</a></span>
				<span class="letter"><a href="authors.php?letter=G">G</a></span>
				<span class="letter"><a href="authors.php?letter=H">H</a></span>
				<span class="letter"><a href="authors.php?letter=I">I</a></span>
				<span class="letter"><a href="authors.php?letter=J">J</a></span>
				<span class="letter"><a href="authors.php?letter=K">K</a></span>
				<span class="letter"><a href="authors.php?letter=L">L</a></span>
				<span class="letter"><a href="authors.php?letter=M">M</a></span>
				<span class="letter"><a href="authors.php?letter=N">N</a></span>
				<span class="letter"><a href="authors.php?letter=O">O</a></span>
				<span class="letter"><a href="authors.php?letter=P">P</a></span>
				<span class="letter"><a href="authors.php?letter=Q">Q</a></span>
				<span class="letter"><a href="authors.php?letter=R">R</a></span>
				<span class="letter"><a href="authors.php?letter=S">S</a></span>
				<span class="letter"><a href="authors.php?letter=T">T</a></span>
				<span class="letter"><a href="authors.php?letter=U">U</a></span>
				<span class="letter"><a href="authors.php?letter=V">V</a></span>
				<span class="letter"><a href="authors.php?letter=W">W</a></span>
				<span class="letter"><a href="authors.php?letter=X">X</a></span>
				<span class="letter"><a href="authors.php?letter=Y">Y</a></span>
				<span class="letter"><a href="authors.php?letter=Z">Z</a></span>
			</div>
				<ul class="dot">
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
	$letter=$_GET['letter'];

	if(!(isValidLetter($letter)))
	{
		echo "<li>Invalid URL</li>";
		
		echo "</ul></div></div>";
		echo "<div class=\"clearfix\"></div></div>";
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


$query = "select * from author where authorname like '$letter%' order by authorname";
/*
$query = "select * from author where authorname like '$letter%' order by authorname";
*/


$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	for($i=1;$i<=$num_rows;$i++)
	{
				$row = $result->fetch_assoc();

		$authid=$row['authid'];
		$authorname=$row['authorname'];

		echo "<li>";
		echo "<span class=\"authorspan\"><a href=\"auth.php?authid=$authid&amp;author=" . urlencode($authorname) . "\">$authorname</a></span>";
		echo "</li>\n";
	}
}
else
{
	echo "<li>Sorry! No author names were found to begin with the letter '$letter' in The Vedanta Kesari</li>";
}

if($result){$result->free();}
$db->close();
?>
				</ul>
			</div>
	</div>
    
<?php include("include_footer.php");?>

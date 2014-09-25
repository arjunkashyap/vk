<?php include("include_header.php");?>
<?php include("include_nav.php");?>
		<div class="archive_holder">
			
<?php

include("connect.php");
$db = @new mysqli('localhost', "$user", "$password", "$database");
if($db->connect_errno > 0)
{
	echo 'Not connected to the database [' . $db->connect_errno . ']';
	echo "</div></div>";
	echo "<div class=\"clearfix\"></div></div>";
	echo "</body></html>";
	exit(1);
}
?>
			<div class="page_title"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</div>
			<div class="archive_search">
				<form method="get" action="search-result.php">
				<table>
<?php

//~ $db = mysql_connect("localhost",$user,$password) or die("Not connected to database");
//~ $rs = mysql_select_db($database,$db) or die("No Database");

echo "<tr>
	<td class=\"left\"><label for=\"autocomplete\" class=\"titlespan\">Author</label></td>
	<td class=\"right\"><input name=\"author\" type=\"text\" class=\"titlespan wide\" id=\"autocomplete\" maxlength=\"150\" />";
	
$query_ac = "select * from author where type regexp '01|02|03|04|05|06|07|08|09|10|11|12|13' order by authorname";

$result_ac = $db->query($query_ac); 
$num_rows_ac = $result_ac ? $result_ac->num_rows : 0;

//~ $result_ac = mysql_query($query_ac);
//~ $num_rows_ac = mysql_num_rows($result_ac);

echo "<script type=\"text/javascript\">$( \"#autocomplete\" ).autocomplete({source: [ ";

$source_ac = '';

if($num_rows_ac > 0)
{
	for($i=1;$i<=$num_rows_ac;$i++)
	{
		//~ $row_ac=mysql_fetch_assoc($result_ac);
		$row_ac = $result_ac->fetch_assoc();

		$authorname=$row_ac['authorname'];

		$source_ac = $source_ac . ", ". "\"$authorname\"";
	}
	$source_ac = preg_replace("/^\, /", "", $source_ac);
}

echo "$source_ac ]});</script></td>";
echo "</tr>
<tr>
	<td class=\"left\"><label for=\"textfield2\" class=\"titlespan\">Title</label></td>
	<td class=\"right\"><input name=\"title\" type=\"text\" class=\"titlespan wide\" id=\"textfield2\" maxlength=\"150\" autocomplete=\"off\"/></td>
</tr>";

if($result_ac){$result_ac->free();}
$db->close();
?>
					<tr>
						<td class="left"><label for="textfield3" class="titlespan">Words</label></td>
						<td class="right"><input name="text" type="text" class="titlespan wide" id="textfield3" maxlength="150" autocomplete="off"/></td>
					</tr>
					<tr>
						<td class="left">&nbsp;</td>
						<td class="right">
							<input name="searchform" type="submit" class="titlespan med" id="button_search" value="Search"/>
							<input name="resetform" type="reset" class="titlespan med" id="button_reset" value="Reset"/>
						</td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
    
<?php include("include_footer.php");?>

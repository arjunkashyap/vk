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
    include("include_footer.php");
	exit(1);
}
?>
			<div class="page_title"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</div>
			<div class="archive_search">
				<form method="get" action="search-result.php">
				<table>
<?php

echo "<tr>
	<td class=\"left\"><label for=\"textfield2\" class=\"titlespan\">Title</label></td>
	<td class=\"right\"><input name=\"title\" type=\"text\" class=\"titlespan wide\" id=\"textfield2\" maxlength=\"150\"/></td>
</tr>
<tr>
	<td class=\"left\"><label for=\"autocomplete\" class=\"titlespan\">Author</label></td>
	<td class=\"right\"><input name=\"author\" type=\"text\" class=\"titlespan wide\" id=\"autocomplete\" maxlength=\"150\" />";
	
$query_ac = "select * from author order by authorname";

$result_ac = $db->query($query_ac);
$num_rows_ac = $result_ac ? $result_ac->num_rows : 0;

echo "<script type=\"text/javascript\">$( \"#autocomplete\" ).autocomplete({source: [ ";

$source_ac = '';

if($num_rows_ac > 0)
{
	for($i=1;$i<=$num_rows_ac;$i++)
	{
		$row_ac = $result_ac->fetch_assoc();

		$authorname=$row_ac['authorname'];

		$source_ac = $source_ac . ", ". "\"$authorname\"";
	}
	$source_ac = preg_replace("/^\, /", "", $source_ac);
}

echo "$source_ac ]});</script></td>";
echo "</tr>";

if($result_ac){$result_ac->free();}
?>
					<tr>
                        <td class="left"><label class="titlespan">Category</label></td>
                        <td class="right">
                            <select name="featid" class="titlespan wide">
                                <option value="">&nbsp;</option>
<?php

$query = "select * from feature where feat_name != '' order by feat_name";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $feat_name=$row['feat_name'];
        $featid=$row['featid'];
        echo "<option value=\"$featid\">" . $feat_name . "</option>";
    }
}

if($result){$result->free();}

?>
                            </select>
                        </td>
                    </tr>
                    <tr>
						<td class="left"><label for="textfield3" class="titlespan">Words</label></td>
						<td class="right"><input name="text" type="text" class="titlespan wide" id="textfield3" maxlength="150"/></td>
					</tr>
                    <tr>
                        <td class="left"><label class="titlespan">Year</label></td>
                        <td class="right"><select name="year1" class="titlespan">
                                <option value="">&nbsp;</option>
<?php

$query = "select distinct year from article order by year";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $year=$row['year'];
        echo "<option value=\"$year\">" . $year . "</option>";
    }
}

if($result){$result->free();}

?>
                        </select>
                        <span class="titlespan" >&nbsp;to&nbsp;</span>
                        <select name="year2" class="titlespan">
                            <option value="">&nbsp;</option>

<?php
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
    for($i=1;$i<=$num_rows;$i++)
    {
        $row = $result->fetch_assoc();

        $year=$row['year'];
        echo "<option value=\"$year\">" . $year . "</option>";
    }
}
if($result){$result->free();}
$db->close();
?>
                            </select>
                        </td>
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

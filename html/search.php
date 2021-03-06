<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/font.css"> <!-- Font style -->
    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="css/jquery-ui.css" /> <!-- jQuery UI style -->
    <link rel="shortcut icon" type="image/ico" href="img/favicon.ico" />

    <link href="css/font-awesome-4.1.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css" /> <!-- Icon gallery (fontAwesome) style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <script src="js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    
    <title>The Vedanta Kesari</title>
</head>
<body>
    <header class="cd-header">
        <div id="cd-logo">
            <a href="../index.html#home">
                <img src="img/logo.png" alt="Logo">
                <span>THE VEDANTA KESARI</span>
            </a>
        </div>
        <nav class="cd-main-nav">
            <ul>
                <li><a href="../index.html#home">Home</a></li>
                <li><a href="../index.html#about">About</a></li>
                <li><a href="../index.html#editors">Editors</a></li>
                <li><a href="../index.html#annualNumbers">Annual Numbers</a></li>
                <li><a href="../index.html#archive">Archive</a> | <a href="volumes.html">Years</a></li>             
                <li><a href="help.html">Help</a></li>
            </ul>
        </nav> <!-- cd-main-nav -->

        <div id="cd-sec-nav">
            <a href="#0" class="cd-sec-nav-trigger">Menu<span></span></a>
            <nav id="cd-sec-main-nav">
                <ul>
                    <li><a href="volumes.html"><i class="fa fa-calendar"></i> Years</a></li>
                    <li><a href="articles.html"><i class="fa fa-files-o"></i> Titles</a></li>
                    <li><a href="authors.html"><i class="fa fa-users"></i> Authors</a></li>
                    <li><a href="features.html"><i class="fa fa-tags"></i> Features</a></li>
                    <li><a href="search.php"><i class="fa fa-search"></i> Search</a></li>
                    <li><a href="pictures.html"><i class="fa fa-image"></i> Pictures</a></li>
                </ul>
            </nav> <!-- cd-sec-main-nav -->
        </div>
    </header>
<main class="cd-main-content">
        <div class="cd-scrolling-bg cd-color-2">
            <div class="cd-container">
                <h1 class="clr1 gapBelow">Archive &gt; Search</h1>
<?php

include("connect.php");
require_once("common.php");

?>
                <div class="archive_search">
                    <form method="get" action="search-result.php">
                        <table>
                            <tr>
                                <td class="left"><label for="textfield2" class="titlespan">Title</label></td>
                                <td class="right"><input name="title" type="text" class="titlespan wide" id="textfield2" maxlength="150"/></td>
                            </tr>
                            <tr>
                                <td class="left"><label for="autocomplete" class="titlespan">Author</label></td>
                                <td class="right"><input name="author" type="text" class="titlespan wide" id="autocomplete" maxlength="150" />
<?php

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
        $source_ac = $source_ac . ', '. '"' . $row_ac['authorname'] . '"';
    }
    $source_ac = preg_replace("/^\, /", "", $source_ac);
}

echo $source_ac . ']});</script></td>';
echo '</tr>';
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
                                <td class="right">
                                    <select name="year1" class="titlespan">
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
                                    <span class="clr1">&nbsp;to&nbsp;</span>
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
                                    <input name="searchform" type="submit" class="clr1 med" id="button_search" value="Search"/>
                                    <input name="resetform" type="reset" class="clr1 med" id="button_reset" value="Reset"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div> <!-- cd-container -->
        </div> <!-- cd-scrolling-bg -->
    </main> <!-- cd-main-content -->
<?php include("include_footer.php");?>

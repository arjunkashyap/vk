#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];


use DBI();

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

$sth11=$dbh->prepare("CREATE TABLE searchtable(title varchar(500),
authid varchar(200),
authorname varchar(1000),
featid varchar(10),
text varchar(5000),
page varchar(10),
page_end varchar(10),
cur_page varchar(10),
volume varchar(3),
part varchar(10),
year varchar(10),
month varchar(10),
titleid varchar(30)) ENGINE=MyISAM");
$sth11->execute();
$sth11->finish();

$sth1=$dbh->prepare("select * from article order by titleid");
$sth1->execute();

while($ref=$sth1->fetchrow_hashref())
{
	$titleid = $ref->{'titleid'};
	$page = $ref->{'page'};
	$page_end = $ref->{'page_end'};
	$cur_page = $ref->{'cur_page'};
	$volume = $ref->{'volume'};
	$part = $ref->{'part'};
	$title = $ref->{'title'};
	$authid = $ref->{'authid'};
	$authorname = $ref->{'authorname'};
	$year = $ref->{'year'};
	$month = $ref->{'month'};
	$featid = $ref->{'featid'};
	
	$title =~ s/'/\\'/g;
	$authorname =~ s/'/\\'/g;
		
	$sth2=$dbh->prepare("select * from testocr where volume='$volume' and part='$part' and cur_page between '$page' and '$page_end'");
	$sth2->execute();
	
	while($ref2=$sth2->fetchrow_hashref())
	{
		print $volume."\n";
		$text = $ref2->{'text'};
		$cur_page = $ref2->{'cur_page'};
			
		$sth4=$dbh->prepare("insert into searchtable values('$title','$authid','$authorname','$featid','$text','$page','$page_end','$cur_page',
			'$volume','$part','$year','$month','$titleid')");
		$text = '';
		$sth4->execute();
		$sth4->finish();
	}
	$sth2->finish();
}

$sth1->finish();
$dbh->disconnect();

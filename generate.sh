#!/bin/sh

host="localhost"
db="vk"
usr="root"
pwd="mysql"

echo "drop database if exists vk; create database vk;" | /usr/bin/mysql -uroot -pmysql

perl insert_author.pl $host $db $usr $pwd
perl insert_feat.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
perl ocr.pl $host $db $usr $pwd
perl searchtable.pl $host $db $usr $pwd
echo "create fulltext index text_index on searchtable (text);" | /usr/bin/mysql -uroot -pmysql vk

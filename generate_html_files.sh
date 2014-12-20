#!/bin/sh

rm html/volume*.html
rm html/toc*.html
rm html/articles*.html
rm html/auth*.html
rm html/feat*.html

php gen_volumes.php
php gen_issues.php
php gen_toc.php
php gen_articles.php
php gen_authors.php
php gen_auth.php
php gen_features.php
php gen_feat.php

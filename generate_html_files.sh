#!/bin/sh

rm html/volume*.html
rm html/toc*.html
rm html/articles*.html
rm html/auth*.html
rm html/feat*.html
rm html/annual*.html
rm html/help.html
rm html/pictures.html
rm html/coverpages.html

php gen_volumes.php
php gen_issues.php
php gen_toc.php
php gen_articles.php
php gen_authors.php
php gen_auth.php
php gen_features.php
php gen_feat.php
php gen_annual-numbers.php
php gen_help.php
php gen_pictures.php
php gen_coverpages.php

cp html/articles_01.html html/articles.html
cp html/authors_01.html html/authors.html

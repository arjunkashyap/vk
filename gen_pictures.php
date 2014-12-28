<?php

$filename = "html/pictures.html";

$cmd = 'wget "http://localhost/vk/html/pictures.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

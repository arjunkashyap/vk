<?php

$filename = "html/annual-numbers.html";

$cmd = 'wget "http://localhost/vk/html/annual-numbers.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

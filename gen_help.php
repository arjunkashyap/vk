<?php

$filename = "html/help.html";

$cmd = 'wget "http://localhost/vk/html/help.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

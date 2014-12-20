<?php

$filename = "html/features.html";

$cmd = 'wget "http://localhost/vk/html/features.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

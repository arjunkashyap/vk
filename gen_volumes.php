<?php

$filename = "html/volumes.html";

$cmd = 'wget "http://localhost/vk/html/volumes.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

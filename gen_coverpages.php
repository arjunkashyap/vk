<?php

$filename = "html/coverpages.html";

$cmd = 'wget "http://localhost/vk/html/coverpages.php" --output-document=' . $filename . ' --quiet';

system($cmd);

?>

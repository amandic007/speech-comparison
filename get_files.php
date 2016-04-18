<?php
sleep(2);
$dir    = 'audio/';
$files = scandir($dir, 1);
$count = count($files);
    	foreach ($files as $i => $value) {
    		if ($count-- <= 2) {
        		break;
    		}
		   echo "<option value=\"$files[$i]\"";
		   echo ">$files[$i]</option>" ;
		}
?>
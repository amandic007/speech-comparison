<?php

function is_dir_empty($dir) {
  if (!is_readable($dir)) return NULL; 
  $handle = opendir($dir);
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {
      return FALSE;
    }
  }
  return TRUE;
}

function get_latest_index($path) {
	$latest_ctime = 0;
	$latest_filename = ''; 
	$latest_index_max = 0;

	$d = dir($path);

	while (false !== ($entry = $d->read())) {
	  $filepath = "{$path}/{$entry}";
	  // could do also other checks than just checking whether the entry is a file
	  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
	    $latest_ctime = filectime($filepath);
	    $latest_filename = $entry;
	    $latest_index = preg_replace("/[^0-9]/","",$latest_filename);
		$latest_index = (int)$latest_index;
		if ($latest_index > $latest_index_max) $latest_index_max = $latest_index;

	  }
	}
	$latest_index = $latest_index_max;
	$latest_index++;
	if ($latest_index < "10") {
    	$latest_index = "0" . $latest_index;
	}

	return $latest_index;
}

// pull the raw binary data from the POST array
$data = substr($_POST['data'], strpos($_POST['data'], ",") + 1);
// decode it
$decodedData = base64_decode($data);
// print out the raw data,

   
$path = "audio/"; 
$d = dir($path);

$fname = "MyRecording" . get_latest_index($path);




$filename = "audio/" . $fname . ".wav";
echo $filename;
// write the data out to the file
$fp = fopen($filename, 'wb');
fwrite($fp, $decodedData);
fclose($fp);
?>
<?PHP
/***********************************
 * Developer : Məmmədov Sadiq Ilham
 * Website   : http://mrsadiq.info
 * Phone     : (+994) 77 434 07 11
 ***********************************/

// Cache the contents to a file
$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
fclose($cached);
ob_end_flush(); // Send the output to the browser
?>
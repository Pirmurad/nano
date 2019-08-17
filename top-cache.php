<?PHP
/***********************************
 * Developer : Məmmədov Sadiq Ilham
 * Website   : http://mrsadiq.info
 * Phone     : (+994) 77 434 07 11
 ***********************************/

$url = $_SERVER["REQUEST_URI"];

$break = Explode('/', $url);
$file="";
for ($i=0;$i<=count($break);$i++){
    if (!empty($break[$i])) {
        $file.= $break[$i]."-";
    }
}
$pos = strpos($url, "html");

if ($pos === false){
    $cachefile = $path."cache/cached-".substr_replace($file ,"",-1).".html";
}else{
    $cachefile = $path."cache/cached-".substr_replace($file ,"",-6).".html";
}

$cachetime = 8000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    // echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    include($cachefile);
    exit;
}
ob_start(); // Start the output buffer
?>
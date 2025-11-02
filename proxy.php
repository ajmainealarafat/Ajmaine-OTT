<?php
// proxy.php?url=<M3U8_URL>
if(!isset($_GET['url'])){
    http_response_code(400);
    echo "No URL provided";
    exit;
}

$url = $_GET['url'];

if(!filter_var($url, FILTER_VALIDATE_URL)){
    http_response_code(400);
    echo "Invalid URL";
    exit;
}

header("Content-Type: application/vnd.apple.mpegurl");
header("Access-Control-Allow-Origin: *");

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($http_code >= 200 && $http_code < 300){
    echo $data;
} else {
    http_response_code($http_code);
    echo "Failed to fetch stream";
}
?>

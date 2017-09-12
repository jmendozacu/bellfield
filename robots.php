<?php
// Parse robots file location using server name
$server_name = 
    isset($_SERVER['HTTP_HOST']) 
    ? $_SERVER['HTTP_HOST'] 
    : 'default';


$robots_file = getcwd() .'/robots/'. $server_name .'/robots.txt';

// Check if robot file exists for current domain, else default
$robots_file = 
    file_exists($robots_file) 
    ? $robots_file 
    : getcwd() .'/robots/default/robots.txt';

// Serve robots file
header("Content-Type: text/plain");
header("Content-Length: ". filesize($robots_file));
readfile($robots_file);
exit;


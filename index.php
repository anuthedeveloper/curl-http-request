<?php
ini_set("display_errors", 1);

require_once "../vendor/autoload.php";

// default constant
define('accessToken', 'token');

// headers 
$headers = [
    'Content-Type: application/json', 'Accept: application/json',
    'Authorization: '.accessToken	
];

define('HOST_API', 'http://localhost/dacam/facs/api-v2/routes/'); // host api url
define('HEADERS', $headers); // additional http headers

// set your config 
// print "OK";
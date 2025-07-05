<?php
require_once dirname(__DIR__) . '/config/base.php';

use AnuDev\CurlHttpRequest\HttpRequest;

// make a post request
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) :
    // your post request body
    $req = new HttpRequest(HOST_API."endpoint/", "POST", $_POST, HEADERS);
    try {
        $response = $req->post();
        // check for error
        if( $req->error ) throw new Exception($req->error, 1);
        // check for additional statusCode
        if( $req->statusCode !== 201 ) throw new Exception("Error code: ". $req->statusCode, 1);
        // decode json object to php array 
        $results = json_decode($response, true);
        // $results['status'] === "Created" => $results['message'] // you could check api response here
        // success response
        $res = array("status" => true, "success" => $results);
    } catch (\Throwable $th) {
        $res = array("status" => false, "error" => $th->getMessage());
    }
    $req->close();    // close the request
    echo json_encode($res);     // output to json
endif;


<?php
require_once ( dirname(__DIR__) . '/index.php' );
use AnuDev\CurlHttpRequest\HttpRequest;

// make a post request
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) :
    // your post request body
    $postdata = json_encode($_POST);
    $req = new HttpRequest(HOST_API."endpoint/", "POST", $postdata, HEADERS);
    try {
        $response = $req->post();
        // check for errors
        if( $req->errors ) throw new Exception($req->errors, 1);
        // check for additional info
        if( $req->info !== 201 ) throw new Exception("Error code: ". $req->info, 1);
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


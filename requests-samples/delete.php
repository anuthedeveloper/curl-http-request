<?php
require_once ( dirname(__DIR__) . '/index.php' );
use AnuDev\CurlHttpRequest\HttpRequest;

if ( $_SERVER['REQUEST_METHOD'] === 'DELETE' ) :
    $postdata = json_encode(["id" => $_GET['id']]);
    $req = new HttpRequest(HOST_API."endpoint/", "DELETE", $postdata, HEADERS);
    try {
        $response = $req->delete();
        // check for errors
        if( $req->errors ) throw new Exception($req->errors, 1);
        // check for additional info
        if( $req->info !== 200 ) throw new Exception("Error code: ". $req->info, 1);
        // decode json object to php array 
        $results = json_decode($response, true);
        // $results['status'] === "Ok" => $results['message'] // you could check api response here
        $res = array("status" => true, "success" => $results);
    } catch (\Throwable $th) {
        $res = array("status" => false, "error" => $th->getMessage());
    }
    $req->close();    // close the request
    echo json_encode($res); // json output
endif;
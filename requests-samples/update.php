<?php
require_once ( dirname(__DIR__) . '/index.php' );
use AnuDev\CurlHttpRequest\HttpRequest;

if ( $_SERVER['REQUEST_METHOD'] == 'PUT' ) :
  // postdata
  $data = json_decode(file_get_contents('php://input'), true);
  $postdata = json_encode($data);
  $req = new HttpRequest(HOST_API."endpoint/", "PUT", $postdata, HEADERS);
  try {
    $response = $req->put();
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
  $req->close();  // close the request
  echo json_encode($res);  // output to json
endif;
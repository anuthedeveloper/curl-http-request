<?php
require_once dirname(__DIR__) . '/config/base.php';

use AnuDev\CurlHttpRequest\HttpRequest;

if ( $_SERVER['REQUEST_METHOD'] == 'PUT' ) :
  // postdata
  $data = json_decode(file_get_contents('php://input'), true);
  $req = new HttpRequest(HOST_API."endpoint/", "PUT", $data, HEADERS);
  try {
    $response = $req->put();
    // check for error
    if( $req->error ) throw new Exception($req->error, 1);
    // check for additional statusCode
    if( $req->statusCode !== 200 ) throw new Exception("Error code: ". $req->statusCode, 1);
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
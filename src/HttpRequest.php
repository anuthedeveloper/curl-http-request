<?php
/**
 * @author Okanlawon Anuoluwapo
 * @package HTTP Request
 */
namespace AnuDev\CurlHttpRequest;

class HttpRequest
{
	public $params;
	private $error_prefix;
	public $errors;
	public $response;
	private $url;
	private $data = [];
	private $method;
	private $header = [];
	public $info = [];
	private $ch = null;

	function __construct( $url, $method, $data = '', $header = '' ){
		$this->error_prefix = 'HTTP Request Error: ';

		$this->url = $url;
		$this->method = strtoupper($method);
		$this->data = $data;
		
		if( empty($header) ){
			$this->header = [
				'Content-Type: application/json',
				'Accept: application/json'	
			];
		}else{
			$this->header = $header;
		}

		$this->init();
	
	}

	private function init(){
		$this->ch = curl_init();
	}

	public function get(){

		if( $this->ch === null ){
			$this->ch = curl_init();
		}

		curl_setopt_array(
			$this->ch, [
				CURLOPT_URL => trim($this->url)."?".http_build_query($this->data),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => $this->header
			]
		);

		$this->response = curl_exec( $this->ch );
		$this->info = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE );
		$this->errors = curl_errno( $this->ch );

		return $this->response;
	}

	public function post(){
		
		if( $this->ch === null ){
			$this->ch = curl_init();
		}

		curl_setopt_array(
			$this->ch, [
				CURLOPT_URL => $this->url,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $this->data,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => $this->header
			]
		);

		$this->response = curl_exec( $this->ch );
		$this->info = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE );
		$this->errors = curl_errno( $this->ch );

		return $this->response;
		
	}

	public function delete(){
		
		if( $this->ch === null ){
			$this->ch = curl_init();
		}

		curl_setopt_array(
			$this->ch, [
				CURLOPT_URL => $this->url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'DELETE',
				CURLOPT_POSTFIELDS => $this->data,
				CURLOPT_HTTPHEADER => $this->header
			]
		);
		
		$this->response = curl_exec( $this->ch );
		$this->info = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE );
		$this->errors = curl_errno( $this->ch );

		return $this->response;

	}

	public function put(){

		if( $this->ch === null ){
			$this->ch = curl_init();
		}

		curl_setopt_array(
			$this->ch, [
				CURLOPT_URL => $this->url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'PUT',
				CURLOPT_POSTFIELDS => $this->data,
				CURLOPT_HTTPHEADER => $this->header
			]
		);
		
		$this->response = curl_exec( $this->ch );
		$this->info = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE );
		$this->errors = curl_errno( $this->ch );

		return $this->response;

	}

	public function close(){
		curl_close( $this->ch );
		$this->ch = null;
	}
	
}

?>

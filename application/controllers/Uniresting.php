<?php

class Uniresting extends Application {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Unirest');
	}

	/**
	 * Try a couple of things per the Unirest docs
	 */
	function index()
	{
		$headers = array('Accept' => 'application/json');
		$query = array('foo' => 'hello', 'bar' => 'world');

		$response = Unirest\Request::post('http://server-test.local/test', $headers, $query);
		print_r($response);
		
//		$response->code;		// HTTP Status code
//		$response->headers;	 // Headers
//		$response->body;		// Parsed body
//		$response->raw_body;	// Unparsed body
	}

}

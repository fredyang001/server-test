<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	function __construct()
	{
		parent::__construct();
		$subdomain = 'umbrella';
		$domain = (strpos($_SERVER['SERVER_NAME'],'.local') > 1) ? 'local' : 'jlparry.com';
		$this->data['umbrella'] = 'http://' . $subdomain . '.' . $domain;
	}

	/**
	 * Sets up the form and renders it.
	 */
	function index()
	{
		$this->data['title'] = 'Umbrella Server Testing';
		$this->data['pagebody'] = 'homepage';

		$this->render();
	}

}

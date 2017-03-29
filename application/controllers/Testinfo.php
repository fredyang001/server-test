<?php

/**
 * Test the "info" services of the PRC server.
 * 
 * Each server has its own testing method below.
 */
class Testinfo extends Application {

	function __construct()
	{
		parent::__construct();
		$subdomain = 'umbrella';
		$domain = (strpos($_SERVER['SERVER_NAME'], '.local') > 1) ? 'local' : 'jlparry.com';
		$protocol = (strpos($_SERVER['SERVER_NAME'], '.local') > 1) ? 'http' : 'https';
		$this->data['umbrella'] = $protocol . '://' . $subdomain . '.' . $domain;
//		$this->data['umbrella'] = 'https://umbrella.jlparry.com';
		$this->data['title'] = 'Test Information Services';
		$this->data['pagebody'] = 'infopage';
		$this->data['workparms'] = array();
		$this->data['workresult'] = '';
	}

	// nothing requested
	function index()
	{
		$this->render();
	}

	function balance()
	{
		$server = $this->data['umbrella'] . '/info/balance';

		// pick a team
		$teams = json_decode(file_get_contents($this->data['umbrella'] . '/info/teams'));
		$pick1 = $teams[array_rand($teams)];
		$this->data['workparms'] = [['key' => 'team', 'value' => $pick1]];

		$result = file_get_contents($server . '/' . $pick1);
		$this->data['workresult'] = stripslashes($result);

		$this->render();
	}

	function scoop()
	{
		$server = $this->data['umbrella'] . '/info/scoop';

		// pick a team
		$teams = json_decode(file_get_contents($this->data['umbrella'] . '/info/teams'));
		$pick1 = $teams[array_rand($teams)];
		$this->data['workparms'] = [['key' => 'team', 'value' => $pick1]];

		$result = file_get_contents($server . '/' . $pick1);
		$this->data['workresult'] = stripslashes($result);

		$this->render();
	}

	function verify()
	{
		$server = $this->data['umbrella'] . '/info/verify';

		// pick one of our parts
		$parts = $this->parts->all();

		$pick1 = empty($parts) ? "" : $parts[array_rand($parts)]->id;
		$this->data['workparms'] = [['key' => 'cacode', 'value' => $pick1]];

		$result = file_get_contents($server . '/' . $pick1);
		$this->data['workresult'] = stripslashes($result);

		$this->render();
	}

	function whomakes()
	{
		$server = $this->data['umbrella'] . '/info/whomakes';

		// we don't know all the models in production, so will pick "A"
		$pieces = [1, 2, 3];
		$pick1 = "a" . $pieces[array_rand($pieces)];
		$this->data['workparms'] = [['key' => 'parttype', 'value' => $pick1]];

		$result = file_get_contents($server . '/' . $pick1);
		$this->data['workresult'] = stripslashes($result);
		$this->render();
	}

	function whoami()
	{
		$server = $this->data['umbrella'] . '/info/whoami';

		// we don't know any other teams' keys, so will have to use our key
		$pick1 = $this->properties->get('apikey');
		$this->data['workparms'] = [['key' => 'key', 'value' => $pick1]];

		$result = file_get_contents($server . '?key=' . $pick1);
		$this->data['workresult'] = stripslashes($result);
		$this->render();
	}

	function job()
	{
		$server = $this->data['umbrella'] . '/info/job';

		// pick a team
		$teams = json_decode(file_get_contents($this->data['umbrella'] . '/info/teams'));
		$pick1 = $teams[array_rand($teams)];
		$this->data['workparms'] = [['key' => 'team', 'value' => $pick1]];

		$result = file_get_contents($server . '/' . $pick1);
		$this->data['workresult'] = stripslashes($result);
		$this->render();
	}

	// test /teams
	function teams()
	{
		$server = $this->data['umbrella'] . '/info/teams';
		$result = file_get_contents($server);
		$this->data['workresult'] = stripslashes($result);
		$this->render();
	}

}

<?php

/**
 * Test the "work" services of the PRC server
 */
class Testwork extends Application {

	function __construct()
	{
		parent::__construct();
		$subdomain = 'umbrella';
		$domain = (strpos($_SERVER['SERVER_NAME'], '.local') > 1) ? 'local' : 'jlparry.com';
		$protocol = (strpos($_SERVER['SERVER_NAME'], '.local') > 1) ? 'http' : 'https';
		$this->data['umbrella'] = $protocol . '://' . $subdomain . '.' . $domain;
//		$this->data['umbrella'] = 'https://umbrella.jlparry.com';
		$this->data['title'] = 'Test Work Services';
		$this->data['pagebody'] = 'workpage';
		$this->data['workparms'] = array();
		$this->data['workresult'] = '';

		$this->trader = $this->properties->get('plant');
		$this->apikey = $this->properties->get('apikey');
	}

	// nothing requested
	function index()
	{
		$this->polish();
	}

	private function polish()
	{
		$this->data['balance'] = $this->properties->get('balance');
		$stuff = array();
		foreach ($this->parts->all() as $part)
			$stuff[] = ["id" => $part->id, "type" => $part->model . $part->piece];
		$this->data['parts'] = $stuff;

		$this->render();
	}

	function registerme()
	{
		$server = $this->data['umbrella'] . '/work/registerme';

		// identify ourself
		$team = $this->properties->get('plant');
		$password = $this->properties->get('password');
		$this->data['workparms'] = [['key' => 'team', 'value' => $team],
			['key' => 'password', 'value' => '********']];

		$result = file_get_contents($server . '/' . $team . '/' . $password);
		$this->data['workresult'] = $result;

		// Handle the registration response
		if (substr($result, 0, 2) == 'Ok')
		{
			// we're in
			$key = substr($result, 3);
			$this->properties->put('apikey', $key);
			$this->parts->truncate();
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $team);
			$this->properties->put('balance', $balance);
		} else
		{
			// failed!
			$this->parts->truncate();
			$this->properties->put('balance', 0);
			$this->properties->remove('apikey');
		}

		$this->polish();
	}

	function buybox()
	{
		$server = $this->data['umbrella'] . '/work/buybox';

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [['key' => 'key', 'value' => $apikey]];

		$result = file_get_contents($server . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		// Handle the bought boxes response
		if (substr($result, 0, 4) != 'Oops')
		{
			$results = json_decode($result);
			foreach ($results as $record)
				$this->parts->add($record);
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $this->trader);
			$this->properties->put('balance', $balance);
		}

		$this->polish();
	}

	function mybuilds()
	{
		$server = $this->data['umbrella'] . '/work/mybuilds';

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [['key' => 'key', 'value' => $apikey]];

		$result = file_get_contents($server . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		// Handle the bought boxes response
		if (substr($result, 0, 4) != 'Oops')
		{
			$results = json_decode($result);
			foreach ($results as $record)
				$this->parts->add($record);
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $this->trader);
			$this->properties->put('balance', $balance);
		}

		$this->polish();
	}

	function recycle()
	{
		$server = $this->data['umbrella'] . '/work/recycle';

		// pick 3 parts randomly
		$parts = $this->parts->all();
		$part1 = $parts[array_rand($parts)]->id;
		$part2 = $parts[array_rand($parts)]->id;
		$part3 = $parts[array_rand($parts)]->id;

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [
			['key' => 'key', 'value' => $apikey],
			['key' => 'part1', 'value' => $part1],
			['key' => 'part2', 'value' => $part2],
			['key' => 'part3', 'value' => $part3],
		];

		$result = file_get_contents($server . '/' . $part1 . '/' . $part2 . '/' . $part3 . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		$this->polish();
	}

	function rebootme()
	{
		$server = $this->data['umbrella'] . '/work/rebootme';

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [['key' => 'key', 'value' => $apikey]];

		$result = file_get_contents($server . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		// Handle the registration response
		if (substr($result, 0, 2) == 'Ok')
		{
			// we're in
			$this->parts->truncate();
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $this->trader);
			$this->properties->put('balance', $balance);
		}

		$this->polish();
	}

	function buymybot()
	{
		$server = $this->data['umbrella'] . '/work/buymybot';

		// pick 3 parts randomly
		$part1 = '';
		$part2 = '';
		$part3 = '';
		$parts = $this->parts->some('piece', 1);
		if (!empty($parts))
			$part1 = $parts[array_rand($parts)]->id;
		$parts = $this->parts->some('piece', 2);
		if (!empty($parts))
			$part2 = $parts[array_rand($parts)]->id;
		$parts = $this->parts->some('piece', 3);
		if (!empty($parts))
			$part3 = $parts[array_rand($parts)]->id;

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [
			['key' => 'key', 'value' => $apikey],
			['key' => 'part1', 'value' => $part1],
			['key' => 'part2', 'value' => $part2],
			['key' => 'part3', 'value' => $part3],
		];

		$result = file_get_contents($server . '/' . $part1 . '/' . $part2 . '/' . $part3 . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		// Handle the purchase at our end
		if (substr($result, 0, 2) == 'Ok')
		{
			// we're in
			$this->parts->delete($part1);
			$this->parts->delete($part2);
			$this->parts->delete($part3);
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $this->trader);
			$this->properties->put('balance', $balance);
		}

		$this->polish();
	}

	function goodbye()
	{
		$server = $this->data['umbrella'] . '/work/goodbye';

		// we need our API key
		$apikey = $this->properties->get('apikey');
		$this->data['workparms'] = [['key' => 'key', 'value' => $apikey]];

		$result = file_get_contents($server . '?key=' . $apikey);
		$this->data['workresult'] = $result;

		// Handle the registration response
		if (substr($result, 0, 2) == 'Ok')
		{
			// we're in
			$this->properties->remove('apikey');
			$this->parts->truncate();
			$balance = file_get_contents($this->data['umbrella'] . '/info/balance/' . $this->trader);
			$this->properties->put('balance', $balance);
		}

		$this->polish();
	}

}

<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetTag;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetTag();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->list();

var_dump($response);
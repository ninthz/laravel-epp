<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetPoll;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetPoll();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->poll("req");

print_r($response['status']);
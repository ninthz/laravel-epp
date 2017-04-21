<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetReseller;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetReseller('117419');
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->delete();

var_dump($response->json());

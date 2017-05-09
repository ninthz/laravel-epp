<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetDomain = new NominetDomain();
$nominetDomain->setHost($host);
$nominetDomain->setUsername($username);
$nominetDomain->setPassword($password);

$parameters = ['domain' => 'domain1.co.uk'];
$response = $nominetDomain->info($parameters);

print_r($response['response']);

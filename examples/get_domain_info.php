<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nd = new NominetDomain();
$nd->setHost($host);
$nd->setUsername($username);
$nd->setPassword($password);

$parameters = ['domain' => 'domain1.co.uk'];
$response = $nd->info($parameters);

print_r($response['response']);

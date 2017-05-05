<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nr = new NominetDomain();
$nr->setHost($host);
$nr->setUsername($username);
$nr->setPassword($password);

$response = $nr->delete("domain5.co.uk");

print_r($response['status']);
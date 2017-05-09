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

$domainName = ["sound-offs.com", "sound-offs2.com"];
$response = $nominetDomain->check($domainName);

print_r($response['response']);

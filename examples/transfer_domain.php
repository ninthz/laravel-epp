<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nc = new NominetDomain();
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$response = $nc->transfer('domain1.co.uk', 'contact_id4');

print_r($response['status']);
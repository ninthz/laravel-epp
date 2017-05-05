<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nc = new NominetContact('contact_id4');
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$response = $nc->info()->toJson();

print_r($response);

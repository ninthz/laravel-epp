<?php

use LaravelEPP\Registrars\Nominets\NominetExtension;

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nd = new \LaravelEPP\Registrars\Nominets\NominetContact('contact_id1');
$nd->setHost($host);
$nd->setUsername($username);
$nd->setPassword($password);

$response = $nd->lockInvestigation();

print_r($response['status']);

<?php

use LaravelEPP\Registrars\Nominets\NominetExtension;

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nd = new \LaravelEPP\Registrars\Nominets\NominetDomain();
$nd->setHost($host);
$nd->setUsername($username);
$nd->setPassword($password);

$response = $nd->lockInvestigation('nominet-test111.co.uk');

print_r($response);

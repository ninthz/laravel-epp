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

$response = $nd->unlock('nominet-test111.co.uk', 'investigation');

// NOTE: Use unlockInvestigation() to unlock and set the type to investigation

print_r($response['status']);

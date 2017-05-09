<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetContact;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$contactId = 'contact_id1';
$nc = new NominetContact($contactId);
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$response = $nc->check();

var_dump($response);

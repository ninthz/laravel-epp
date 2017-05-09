<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetFork;

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominetFork = new NominetFork;
$nominetFork->setHost($host);
$nominetFork->setUsername($username);
$nominetFork->setPassword($password);

$paremeters = [
    'original_contact_id' => 'ORIGINAL_CONTACT_ID',
    'new_contact_id' => 'ORIGINAL_CONTACT_ID',
    'domain_names' => [
        'example1.co.uk',
        'example2.co.uk',
        'example3.co.uk'
    ]
];

$response = $nominetFork->fork($paremeters);

print_r($response);

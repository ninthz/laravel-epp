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

$data = [
    'domain_name' => 'domain5.co.uk',
    'domain_unit' => 'y',
    'domain_period' => '1',
    'domain_hostObj' => [
        'example.com',
    ],
    'domain_registrant' => 'contact_id4',
    'domain_pw' => 'n7tobH44LR8F4uN',

    'domain_notes' => 'notes',
];

$response = $nominetDomain->create($data, true);

print_r($response['response']);

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

$data = [
    'domain_name' => 'nominet-test111.co.uk',
    'domain_unit' => 'y',
    'domain_period' => '2',
    'domain_hostObj' => [
        'example.com',
    ],
    'domain_registrant' => 'contact_id4',
    'domain_pw' => 'n7tobH44LR8F4uN',
];

$response = $nc->create($data, false);

//var_dump($response);
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
        'ns11.nominet.org.uk',
        'ns12.nominet.org.uk',
    ],
    'domain_registrant' => 'ab-c123456',
    'domain_pw' => 'PW',
];

$response = $nc->create($data, true);

var_dump($response);
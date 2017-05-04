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
    'domain_add_hostObj' => [
        'ns11.nominet.org.uk',
        'ns12.nominet.org.uk',
    ],
    'domain_pw' => 'PW',
];

$response = $nc->update($data, true)->toArray();
var_dump($response['dom']);
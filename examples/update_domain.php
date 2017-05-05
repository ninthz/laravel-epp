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
    'domain_name' => 'domain1.co.uk',
    'domain_rem_hostObj' => [
        'example2.com',
    ],
    'domain_pw' => 'PW',

    'domain_notes' => 'notes',
];

$response = $nc->update($data, true);
print_r($response['status']);
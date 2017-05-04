<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\{NominetContact, NominetExtension};

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nc = new NominetContact('contact_id4');
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);
$nc->setExtensions([
    NominetExtension::CONTACT_NOM,
]);

$data = [
    'contact_name' => 'Firstname Last',
    'contact_org' => 'Example org.',
    'contact_street' => [
        'Street 1',
        'Street 2',
    ],
    'contact_city' => 'Oxford',
    'contact_sp' => 'England',
    'contact_pc' => 'OX1 1AH',
    'contact_cc' => 'GB',
    'contact_voice' => '+44.1865123456',
    'contact_email' => 'contact@example.com',
    'contact_pw' => 'n7tobH44LR8F4uN',
//    'contact_trade_name' => 'Trade name',
//    'contact_type' => 'Type',
//    'contact_co_no' => 'Co No',
//    'contact_opt_out' => 'Opt Out',
];

$response = $nc->create($data, false)->toArray();

var_dump($response['dom']->contactCreateMapper());
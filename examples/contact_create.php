<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nc = new \LaravelEPP\Registrars\Nominets\NominetContact();
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$data = [
    'contact_name' => 'Firstname Lastname',
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

//var_dump($response);
<?php

require __DIR__.'/autoload.php';

$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'epp.nominet.org.uk';

$nc = new \LaravelEPP\Registrars\Nominets\NominetContact('12345678');
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$data = [
    'contact_name' => 'Name',
    'contact_org' => 'Organization',
    'contact_street' => [
        'Street 1',
        'Street 2',
    ],
    'contact_city' => 'City',
    'contact_sp' => 'SP',
    'contact_pc' => 'PC',
    'contact_cc' => 'CC',
    'contact_voice' => 'Voice',
    'contact_email' => 'Email',
    'contact_pw' => 'PW',
    'contact_trade_name' => 'Trade name',
    'contact_type' => 'Type',
    'contact_co_no' => 'Co No',
    'contact_opt_out' => 'Opt Out',
];

$response = $nc->create($data, true)->toArray();

//var_dump($response);
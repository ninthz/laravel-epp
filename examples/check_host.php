<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetHost;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nc = new NominetHost();
$nc->setHost($host);
$nc->setUsername($username);
$nc->setPassword($password);

$hostName = 'ns1.nominet.org.uk';
$response = $nc->check($hostName)->toArray();

var_dump($response['dom']->getCheckHost());
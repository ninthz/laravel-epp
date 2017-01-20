<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\NominetDomain;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nb = new NominetDomain();
$nb->setHost($host);
$nb->setUsername($username);
$nb->setPassword($password);

$parameters = ['domain' => 'herbert.co.uk'];
$response = $nb->info($parameters);

var_dump($response["dom"]->getDomainInfo());

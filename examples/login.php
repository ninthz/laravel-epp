<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\Nominet;

$username = getenv('NOMINET_LIVE_USERNAME');
$password = getenv('NOMINET_LIVE_PASSWORD');
$host = 'epp.nominet.org.uk';

$nominet = new Nominet();
$nominet->setHost($host);
$nominet->setUsername($username);
$nominet->setPassword($password);
$nominet->login();

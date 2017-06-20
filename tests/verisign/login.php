<?php

require __DIR__.'/../autoload.php';

use LaravelEPP\Registrars\Verisign\Verisign;

$username = getenv('VERISIGN_USERNAME');
$password = getenv('VERISIGN_PASSWORD');
$cert = getenv('CERT');
$privateKey = getenv('PRIVATE_KEY');
$host = 'epp-ote.verisign-grs.com';

try {
    $verisign = new Verisign();
    $verisign->eppClient()->setHost($host);
    $verisign->eppClient()->enableCertification($cert, $privateKey);
    $verisign->setUsername($username);
    $verisign->setPassword($password);
    if ($verisign->login()) {
        echo "Connect";
    }
} catch (\Exception $e) {
    print_r($e);
}

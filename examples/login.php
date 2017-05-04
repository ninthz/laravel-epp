<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\{Nominet, NominetExtension};


$username = getenv('NOMINET_TEST_USERNAME');
$password = getenv('NOMINET_TEST_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';

$nominet = new Nominet();
$nominet->setHost($host);
$nominet->setUsername($username);
$nominet->setPassword($password);
$nominet->setExtensions([
    NominetExtension::DOMAIN_NOM,
    NominetExtension::CONTACT_NOM,
    NominetExtension::STD_LIST,
    NominetExtension::STD_NOTIFICATIONS
]);
if ($nominet->login()) {
    echo "Connect";
}

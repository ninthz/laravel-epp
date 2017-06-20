<?php

require __DIR__.'/autoload.php';

use LaravelEPP\Registrars\Nominets\{Nominet, NominetExtension};


$username = getenv('NOMINET_DOT_BLOG_USERNAME');
$password = getenv('NOMINET_DOT_BLOG_PASSWORD');
$host = 'testbed-epp.nominet.org.uk';
$host = 'testbed-blog.epp.nominet.uk';

try {
    $nominet = new Nominet();
    $nominet->eppClient()->setHost($host);
    $nominet->eppClient()->enableCertification('/etc/pki/tls/certs/ca-bundle.crt');
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
} catch (\Exception $e) {
    print_r($e);
}

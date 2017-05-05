<?php

require __DIR__.'/autoload.php';

use LaravelEPP\EPP\Tools\XmlUtility;

$xmlUtil = new XmlUtility();

// var_dump($xmlUtil->parseXmlResponse(__DIR__.'/resources/response_create_contact.xml', 'contact:creData', 'result'));
var_dump($xmlUtil->parseXmlResponse(__DIR__.'/resources/response_list_reseller.xml', 'reseller:listData', 'result'));
<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

class NominetDelete extends Nominet
{

  public function __construct()
  {
    parent::__construct();
  }

  public function __destruct()
  {
    $this->logout();
    parent::__destruct();
  }

  public function delete(String $domainName)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('delete'));
      $mappers = [
          '{domain_name}' => $domainName,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}
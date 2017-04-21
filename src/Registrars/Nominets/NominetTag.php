<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetTag extends Nominet
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

  public function list()
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('list-tag'));
      return  $this->epp_client->sendRequest($xml);
    }
  }
}
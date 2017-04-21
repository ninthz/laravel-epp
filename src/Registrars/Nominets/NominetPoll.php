<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetPoll extends Nominet
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

  public function poll(String $op)
  {
    if ($op !== 'req' && $op !== 'ack') throw new \Exception("Invalid argument the value must be 'req' or 'ack'");
    

    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('poll'));
      $mappers = [
          '{op}' => $op,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}
<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetContact extends Nominet
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

  public function optOut($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('optout-contact'));
      $mappers = [
        '{contact_id}'    => $parameters['contact_id'] ?? '',
        '{opt_out}' => ($parameters['opt_out'] == true ? 'Y' : 'N'),
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function privacy($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('privacy-contact'));
      $mappers = [
        '{contact_id}'    => $parameters['contact_id'] ?? '',
        '{privacy}' => ($parameters['privacy'] == true ? '0' : '1'),
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function info($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('info-contact'));
      $mappers = [
        '{contact_id}'    => $parameters['contact_id'] ?? ''
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function updateType($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('update-contact-type'));
      $mappers = [
        '{contact_id}'    => $parameters['contact_id'] ?? '',
        '{type}'          => $parameters['type'] ?? ''
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}

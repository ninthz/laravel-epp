<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetContact extends Nominet
{

  const CONTACT_TYPE_INDIVIDUAL = 'IND';

  const CONTACT_TYPE_FOREIGN_INDIVIDUAL = 'FIND';

  const CONTACT_TYPE_LIMITED = 'LTD';

  const CONTACT_TYPE_NON_UK_COPERATION = 'FCORP';

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

  public function updateTradingName($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('update-contact-trading-name'));
      $mappers = [
        '{contact_id}'    => $parameters['contact_id'] ?? '',
        '{trading_name}'   => $parameters['trading_name'] ?? ''
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function removeTradingName($contactId)
  {
    return $this->updateTradingName([
      'contact_id' => $contactId,
      'trading_name' => '',
    ]);
  }

  public function check(String $contactId)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('check-contact'));
      $mappers = [
        '{contact_id}' => $contactId,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}

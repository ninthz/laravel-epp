<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetDomain extends Nominet
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

  public function info($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('info-domain'));
      $mappers = [
        '{domain}' => $parameters['domain'] ?? '',
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function updateReseller($parameters)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('update-domain-reseller'));
      $mappers = [
        '{reference}'    => $parameters['reference'] ?? '',
        '{domain}' => $parameters['domain'] ?? '',
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function check(String $domainName)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('check-domain'));
      $mappers = [
        '{domain_name}' => $domainName,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  public function list(int $year, int $month)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('list-domain'));
      $mappers = [
        '{year_month}' => "{$year}-{$month}",
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}

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

  public function check(Array $domainNames)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('check-domain'));
      $mappers = [
        '{domain_name}' => $domainNames,
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

  public function delete(String $domainName)
  {
    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('delete-domain'));
      $mappers = [
          '{domain_name}' => $domainName,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  /**
  * @param $curExpDate String   format yyyy-mm-dd
  * @param $unit String   'm' or 'y'
  */
  public function renew(String $domainName, String $curExpDate, String $unit, int $period)
  {
    if ($unit !== 'y' && $unit !== 'm') throw new \Exception("Invalid argument the unit must be 'm' or 'y'");

    $dates = explode('-', $curExpDate);
    if (count($dates) != 3 || strlen($dates[0]) != 4 || $dates[1] < 1 || $dates[1] > 12 || $dates[2] < 1 || $dates[2] > 31)
      throw new \Exception("Invalid argument format the curExpDate must be yyyy-mm-dd");

    if ($this->login()) {
      $xml = file_get_contents($this->getDataXMLPath('renew-domain'));
      $mappers = [
          '{domain_name}' => $domainName,
          '{domain_curExpDate}' => $curExpDate,
          '{domain_unit}' => $unit,
          '{domain_period}' => $period,
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }
}

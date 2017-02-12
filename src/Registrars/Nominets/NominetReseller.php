<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetReseller extends Nominet
{

  function __construct()
  {
    parent::__construct();
  }

  function __destruct()
  {
    $this->logout();
    parent::__destruct();
  }

  function create($parameters)
  {
    if ($this->login(true)) {
      $xml = file_get_contents($this->getDataXMLPath('create-reseller'));
      $mappers = [
        '{reference}'    => $parameters['reference'] ?? '',
        '{trading_name}' => $parameters['trading_name'] ?? '',
        '{url}' => $parameters['url'] ?? '',
        '{email}' => $parameters['email'] ?? '',
        '{telephone}' => $parameters['telephone'] ?? '',
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  function delete($parameters)
  {
    if ($this->login(true)) {
      $xml = file_get_contents($this->getDataXMLPath('delete-reseller'));
      $mappers = [
        '{reference}' => $parameters['reference'] ?? ''
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  function info($parameters)
  {
    if ($this->login(true)) {
      $xml = file_get_contents($this->getDataXMLPath('info-reseller'));
      $mappers = [
        '{reference}' => $parameters['reference']
      ];
      $xml = $this->mapParameters($xml, $mappers);
      return  $this->epp_client->sendRequest($xml);
    }
  }

  function list()
  {
    if ($this->login(true)) {
      $xml = file_get_contents($this->getDataXMLPath('list-reseller'));
      return $this->epp_client->sendRequest($xml);
    }
  }

  function update($parameters)
  {
    if ($this->login(true)) {
      $xml = file_get_contents($this->getDataXMLPath('update-reseller'));
      $mappers = [
        '{reference}'    => $parameters['reference'] ?? '',
        '{trading_name}' => $parameters['trading_name'] ?? '',
        '{url}' => $parameters['url'] ?? '',
        '{email}' => $parameters['email'] ?? '',
        '{telephone}' => $parameters['telephone'] ?? '',
      ];
      $xml = $this->mapParameters($xml, $mappers);
      $response = $this->epp_client->sendRequest($xml);

      if(!$response['status'])
      {
        if($response['message'] != 'Error: Parameter value range error')
        {
          return $response;
        }

        $response['status'] = true;
        $response['message'] = 'Update success';
        return $response;
      }

      return $response;
    }
  }
}

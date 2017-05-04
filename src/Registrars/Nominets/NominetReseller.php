<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetReseller extends Nominet
{

    /**
     * Reference like a reseller id
     */
    private $reference;

    public function __construct($reference = '')
    {
        parent::__construct();
        $this->reference = $reference;
    }

    public function __destruct()
    {
        $this->logout();
        parent::__destruct();
    }

    /**
     * Get the value of reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the value of reference
     *
     * @param string reference
     *
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function makeMapper($parameters = [])
    {
      return array_merge($parameters, ['{reference}' => $this->reference]);
    }

    function create(Array $parameters)
    {
        if ($this->login(Nominet::RESELLER_ACCESS)) {
          $xml = file_get_contents($this->getDataXMLPath('create-reseller'));

          $mappers = $this->makeMapper([
            '{trading_name}' => $parameters['trading_name'] ?? '',
            '{url}' =>  $parameters['url'] ?? '',
            '{email}' => $parameters['email'] ?? '',
            '{telephone}' => $parameters['telephone'] ?? '',
          ]);

          $xml = $this->mapParameters($xml, $mappers);
          return  $this->epp_client->sendRequest($xml);
        }
    }

    function delete()
    {
        if ($this->login(Nominet::RESELLER_ACCESS)) {
          $xml = file_get_contents($this->getDataXMLPath('delete-reseller'));

          $mappers = $this->makeMapper();

          $xml = $this->mapParameters($xml, $mappers);
          return  $this->epp_client->sendRequest($xml);
        }
    }

    function info()
    {
        if ($this->login(Nominet::RESELLER_ACCESS)) {
          $xml = file_get_contents($this->getDataXMLPath('info-reseller'));

          $mappers = $this->makeMapper();

          $xml = $this->mapParameters($xml, $mappers);
          return  $this->epp_client->sendRequest($xml);
        }
    }

    function list()
    {
        if ($this->login(Nominet::RESELLER_ACCESS)) {
          $xml = file_get_contents($this->getDataXMLPath('list-reseller'));
          return $this->epp_client->sendRequest($xml);
        }
    }

    function update(Array $parameters)
    {
        if ($this->login(Nominet::RESELLER_ACCESS)) {
          $xml = file_get_contents($this->getDataXMLPath('update-reseller'));

          $mappers = $this->makeMapper([
            '{trading_name}' => $parameters['trading_name'] ?? '',
            '{url}' =>  $parameters['url'] ?? '',
            '{email}' => $parameters['email'] ?? '',
            '{telephone}' => $parameters['telephone'] ?? '',
          ]);

          $xml = $this->mapParameters($xml, $mappers);
          return $this->epp_client->sendRequest($xml);
        }
    }



}

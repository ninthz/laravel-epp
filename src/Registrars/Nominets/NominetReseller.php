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
        $mappers = $this->makeMapper([
            '{trading_name}' => $parameters['trading_name'] ?? null,
            '{url}' =>  $parameters['url'] ?? null,
            '{email}' => $parameters['email'] ?? null,
            '{voice}' => $parameters['telephone'] ?? null,
        ]);

        return $this->sendRequest('create-reseller', 'reseller:infData', $mappers, [], Nominet::RESELLER_ACCESS);
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
        return $this->sendRequest('info-reseller', 'reseller:infData', $this->makeMapper(), [], Nominet::RESELLER_ACCESS);
    }

    function list()
    {
        return $this->sendRequest('list-reseller', 'reseller:listData', [], [], Nominet::RESELLER_ACCESS);
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

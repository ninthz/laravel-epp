<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetContact extends Nominet
{
    private $contactId;

    const CONTACT_TYPE_INDIVIDUAL = 'IND';

    const CONTACT_TYPE_FOREIGN_INDIVIDUAL = 'FIND';

    const CONTACT_TYPE_LIMITED = 'LTD';

    const CONTACT_TYPE_NON_UK_COPERATION = 'FCORP';

    public function __construct($contactId = '')
    {
      parent::__construct();
      $this->contactId = $contactId;
    }

    public function __destruct()
    {
      $this->logout();
      parent::__destruct();
    }

    public function getContactId()
    {
        return $this->contactId;
    }

    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    public function makeMapper($parameters = [])
    {
      return array_merge($parameters, ['{contact_id}' => $contactId]);
    }

    public function optOut($parameters)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('optout-contact'));

        $mappers = $this->makeMapper([
          '{opt_out}' => ($parameters['opt_out'] == true ? 'Y' : 'N')
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function privacy($parameters)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('privacy-contact'));

        $mappers = $this->makeMapper([
          '{privacy}' => ($parameters['privacy'] == true ? '0' : '1')
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function info($parameters)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('info-contact'));

        $mappers = $this->makeMapper();

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function updateType($parameters)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('update-contact-type'));

        $mappers = $this->makeMapper([
          '{type}'          => $parameters['type'] ?? ''
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function updateTradingName($parameters)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('update-contact-trading-name'));

        $mappers = $this->makeMapper([
          '{trading_name}'          => $parameters['trading_name'] ?? ''
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function removeTradingName()
    {
      return $this->updateTradingName();
    }

    public function check(String $contactId)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('check-contact'));

        $mappers = $this->makeMapper();

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function validate()
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('validate-contact'));

        $mappers = $this->makeMapper();

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

}

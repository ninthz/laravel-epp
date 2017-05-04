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

      $this->setExtensions([
          NominetExtension::CONTACT_NOM
      ]);
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
      return array_merge($parameters, ['{contact_id}' => $this->contactId]);
    }

    public function optOut($optOut)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('optout-contact'));

        $mappers = $this->makeMapper([
          '{opt_out}' => ($optOut == true ? 'Y' : 'N')
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function privacy($privacy)
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('privacy-contact'));

        $mappers = $this->makeMapper([
          '{privacy}' => ($privacy == true ? '0' : '1')
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function info()
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('info-contact'));

        $mappers = $this->makeMapper();

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function updateType($type = '')
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('update-contact-type'));

        $mappers = $this->makeMapper([
          '{type}' => $type
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function updateTradingName($tradingName = '')
    {
      if ($this->login()) {
        $xml = file_get_contents($this->getDataXMLPath('update-contact-trading-name'));

        $mappers = $this->makeMapper([
          '{trading_name}' => $tradingName
        ]);

        $xml = $this->mapParameters($xml, $mappers);
        return  $this->epp_client->sendRequest($xml);
      }
    }

    public function removeTradingName()
    {
      return $this->updateTradingName();
    }

    public function check()
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

    public function create($data, $withExtension = false)
    {
        if ($this->login()) {

            if(!$withExtension) {
                $xml = file_get_contents($this->getDataXMLPath('contact-create'));
            } else {
                $xml = file_get_contents($this->getDataXMLPath('contact-create-with-extension'));
            }

            $mappings = [
                '{contact_name}' => $data['contact_name'],
                '{contact_org}' => $data['contact_org'],
                '{contact_street}' => $data['contact_street'],
                '{contact_city}' => $data['contact_city'],
                '{contact_sp}' => $data['contact_sp'],
                '{contact_pc}' => $data['contact_pc'],
                '{contact_cc}' => $data['contact_cc'],
                '{contact_email}' => $data['contact_email'],
                '{contact_voice}' => $data['contact_voice'] ?? null,
                '{contact_fax}' => $data['contact_fax'] ?? null,
                '{contact_pw}' => $data['contact_pw'],
            ];

            if($withExtension) {
                $mappings = array_merge($mappings, [
                    '{contact_trade_name}' => $data['contact_trade_name'],
                    '{contact_type}' => $data['contact_type'],
                    '{contact_co_no}' => $data['contact_co_no'],
                    '{contact_opt_out}' => $data['contact_opt_out'],
                ]);
            }

            $mappers = $this->makeMapper($mappings);

            $xml = $this->mapParameters($xml, $mappers);

            return  $this->epp_client->sendRequest($xml);
        }
    }

    public function update($data)
    {

        if ($this->login()) {
            // if ()
        }
    }

}

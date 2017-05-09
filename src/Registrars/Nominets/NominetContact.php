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

    private $lockTypes = [];

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

    public function create(Array $data = [])
    {
        $mappings = [];

        foreach ($data as $key => $value) {
            $mappings['{'.$key.'}'] = $value;
        }

        $mappers = $this->makeMapper($mappings);

        return $this->sendRequest('create-contact', '', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }

    public function update(Array $data = [])
    {
        $mappings = [];

        foreach ($data as $key => $value) {
            $mappings['{'.$key.'}'] = $value;
        }

        $mappers = $this->makeMapper($mappings);

        return $this->sendRequest('update-contact', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }

    /*
     * LOCK & UNLOCK function Zone
     * LOCK have 3 types at now is
     * ['data quality', 'investigation', 'opt-out']
     */

    protected function lock($type)
    {
        $mappers = $this->makeMapper(['{type}' => $type]);

        return $this->sendRequest('lock-contact', '', $mappers, [ NominetExtension::STD_LOCKS ]);
    }

    private function unlock($type)
    {
        $mappers = $this->makeMapper(['{type}' => $type]);

        return $this->sendRequest('unlock-contact', '', $mappers, [ NominetExtension::STD_LOCKS ]);
    }

    public function lockDataQuality()
    {
        return $this->lock(NominetLockType::DATA_QUALITY);
    }

    public function unlockDataQuality()
    {
        return $this->unlock(NominetLockType::DATA_QUALITY);
    }

    public function lockInvestigation()
    {
        return $this->lock(NominetLockType::INVESTIGATION);
    }

    public function unlockInvestigation()
    {
        return $this->unlock(NominetLockType::INVESTIGATION);
    }

    public function lockOptOut()
    {
        return $this->lock(NominetLockType::OPT_OUT);
    }

    public function unlockOptOut()
    {
        return $this->unlock(NominetLockType::OPT_OUT);
    }
}

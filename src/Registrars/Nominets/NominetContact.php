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

    public function info()
    {
      $mappers = $this->makeMapper();

      return $this->sendRequest('info-contact', 'contact:infData', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }

    public function check()
    {
      $mappers = $this->makeMapper();

      return $this->sendRequest('check-contact', '', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }

    public function validate()
    {
      $mappers = $this->makeMapper();

      return $this->sendRequest('validate-contact', '', $mappers, [ NominetExtension::CONTACT_NOM, NominetExtension::NOM_DATA_QUALITY ]);
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

    public function privacyOn()
    {
        $mappers = $this->makeMapper(['{opt}' => '0']);

        return $this->sendRequest('privacy-contact', '', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }

    public function privacyOff()
    {
        $mappers = $this->makeMapper(['{opt}' => '1']);

        return $this->sendRequest('privacy-contact', '', $mappers, [ NominetExtension::CONTACT_NOM ]);
    }
}

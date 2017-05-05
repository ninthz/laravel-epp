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
        $mappers = [
            '{year_month}' => "{$year}-{$month}",
        ];
        return $this->sendRequest('list-domain', 'list:listData', $mappers, [NominetExtension::STD_LIST]);
    }

    public function create(Array $data, bool $extension = false)
    {
        if ($data['domain_unit'] !== 'y' && $data['domain_unit'] !== 'm') throw new \Exception("Invalid argument the domain_unit must be 'm' or 'y'");

        $mappers = [
            '{domain_name}' => $data['domain_name'],
            '{domain_unit}' => $data['domain_unit'],
            '{domain_period}' => $data['domain_period'],
            '{domain_hostObj}' => $data['domain_hostObj'],
            '{domain_registrant}' => $data['domain_registrant'],
            '{domain_pw}' => $data['domain_pw'],
        ];

        if ($extension)
        {
            $xml = 'create-domain-with-extension';
            
            $mappers['{domain_auto_bill}'] = $data['domain_auto_bill'] ?? null;
            $mappers['{domain_next_bill}'] = $data['domain_next_bill'] ?? null;
            $mappers['{domain_notes}'] = $data['domain_notes'] ?? null;
            $mappers['{domain_reseller}'] = $data['domain_reseller'] ?? null;
        }
        else 
            $xml = 'create-domain';

        return $this->sendRequest($xml, 'domain:creData', $mappers, [NominetExtension::DOMAIN_NOM]);
    }

    public function update(Array $data, bool $extension = false)
    {

        $mappers = [
            '{domain_name}' => $data['domain_name'],
            '{domain_add_hostObj}' => $data['domain_add_hostObj'] ?? null,
            '{domain_remove_hostObj}' => $data['domain_remove_hostObj'] ?? null,
            '{domain_registrant}' => $data['domain_registrant'] ?? null,
            '{domain_pw}' => $data['domain_pw'] ?? null,
        ];

        if ($extension)
        {
            $xml = 'update-domain-with-extension';
            
            $mappers['{domain_auto_bill}'] = $data['domain_auto_bill'] ?? null;
            $mappers['{domain_next_bill}'] = $data['domain_next_bill'] ?? null;
            $mappers['{domain_notes}'] = $data['domain_notes'] ?? null;
            $mappers['{domain_reseller}'] = $data['domain_reseller'] ?? null;
        }
        else 
            $xml = 'update-domain';

        return $this->sendRequest($xml, 'domain:creData', $mappers, [NominetExtension::DOMAIN_NOM]);
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

    public function unrenew(Array $domainNames)
    {
        if ($this->login()) {
            $xml = file_get_contents($this->getDataXMLPath('unrenew-domain'));
            $mappers = [
                '{domain_name}' => $domainNames,
            ];
            $xml = $this->mapParameters($xml, $mappers);
            return  $this->epp_client->sendRequest($xml);
        }
    }

    public function lock(String $domainName, String $type)
    {
        return $this->sendRequest('lock-domain', [
            '{domain_name}' => $domainName,
            '{type}' => $type,
        ], [NominetExtension::STD_LOCKS]);
    }

    public function lockInvestigation(String $domainName)
    {
        return $this->lock($domainName, 'investigation');
    }

    public function unlock(String $domainName, String $type)
    {
        return $this->sendRequest('unlock-domain', [
            '{domain_name}' => $domainName,
            '{type}' => $type,
        ], [NominetExtension::STD_LOCKS]);
    }

    public function unlockInvestigation(String $domainName)
    {
        return $this->unlock($domainName, 'investigation');
    }
}

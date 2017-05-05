<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;
use phpDocumentor\Reflection\Types\Mixed;

/**
 * Nominet Reseller class service
 */
class NominetHost extends Nominet
{

    private $hostname;

    public function __construct($hostname = '')
    {
        parent::__construct();

        $this->hostname = $hostname;
    }

    public function __destruct()
    {
        $this->logout();
        parent::__destruct();
    }

    /**
     * Check host
     * @return Mixed
     */
    public function check()
    {
        if ($this->login()) {
            $xml = file_get_contents($this->getDataXMLPath('check-host'));
            $mappers = [
                '{host_name}' => $this->hostname,
            ];
            $xml = $this->mapParameters($xml, $mappers);
            return $this->epp_client->sendRequest($xml);
        }
    }

    /**
     * Get host name info
     * @return Mixed
     */
    public function info()
    {
        $mappers = [
            '{host_name}' => $this->hostname,
        ];

        return $this->sendRequest('host-info', $mappers, [], Nominet::HOST_ACCESS);
    }

    /**
     * Create host
     * @param String $ip
     * @return Mixed
     */
    public function create(String $ip)
    {
        if ($this->login()) {
            $xml = file_get_contents($this->getDataXMLPath('host-create'));
            $mappers = [
                '{host_name}' => $this->hostname,
                '{host_ip}' => $ip,
            ];
            $xml = $this->mapParameters($xml, $mappers);
            return $this->epp_client->sendRequest($xml);
        }
    }
}

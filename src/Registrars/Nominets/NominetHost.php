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
        $mappers = [
            '{host_name}' => $this->hostname,
        ];
        return $this->sendRequest('check-host', 'host:chkData', $mappers, [], Nominet::HOST_ACCESS);
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

        return $this->sendRequest('host-info', 'host:infData', $mappers, [], Nominet::HOST_ACCESS);
    }

    /**
     * Create host
     * @param String $ip
     * @return Mixed
     */
    public function create(String $ip)
    {
        $mappers = [
            '{host_name}' => $this->hostname,
            '{host_ip}' => $ip,
        ];

        return $this->sendRequest('host-create', 'host:creData', $mappers, [], Nominet::HOST_ACCESS);
    }
}

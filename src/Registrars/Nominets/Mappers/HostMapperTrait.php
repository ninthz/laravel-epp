<?php
/**
 * Created by PhpStorm.
 * User: pangpondpon
 * Date: 4/21/2017 AD
 * Time: 2:11 PM
 */

namespace LaravelEPP\Registrars\Nominets\Mappers;


trait HostMapperTrait
{

    public $ns_host = 'urn:ietf:params:xml:ns:host-1.0';

    public function getCheckHost() {
        $host_info = [];
        $host_info['name'] = $this->getDataItem($this->ns_host, 'name');
        $host_info['reason'] = $this->getDataItem($this->ns_host, 'reason');

        return $host_info;
    }

    /**
     * Get host info array from LaravelEPP\Epp\Tools\XMLDom Object
     * @return array
     */
    public function getHostInfo()
    {
        $host_info = [];

        $host_info['name'] = $this->getDataItem($this->ns_host, 'name');
        $host_info['roid'] = $this->getDataItem($this->ns_host, 'roid');
        $host_info['status'] = $this->getArrayElementsResponse($this->ns_host, 'clID', null, true, 's');
        $host_info['clID'] = $this->getArrayElementsResponse($this->ns_host, 'clID');
        $host_info['crDate'] = $this->getDataItem($this->ns_host, 'crDate');

        return $host_info;
    }
}
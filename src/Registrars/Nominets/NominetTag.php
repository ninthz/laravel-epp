<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;

/**
 * Nominet Reseller class service
 */
class NominetTag extends Nominet
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

    public function list()
    {
        return $this->sendRequest('list-tag', 'tag:infData', [], [], Nominet::TAGLIST_ACCESS);
    }
}
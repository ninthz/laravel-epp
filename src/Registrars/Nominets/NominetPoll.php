<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\Registrars\Nominets\Nominet;
use LaravelEPP\Registrars\Nominets\NominetExtension;

/**
 * Nominet Reseller class service
 */
class NominetPoll extends Nominet
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

    public function poll(String $op)
    {
        if ($op !== 'req' && $op !== 'ack') throw new \Exception("Invalid argument the value must be 'req' or 'ack'");
        
        $mappers = [
            '{op}' => $op,
        ];
        return $this->sendRequest('poll', 'poll:infData', $mappers, [NominetExtension::STD_NOTIFICATIONS]);
    }
}
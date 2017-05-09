<?php

namespace LaravelEPP\Registrars\Nominets;

class NominetHandshake extends Nominet
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

    function accept(Array $data)
    {
        $mappers = ['{case_id}' => $data['case_id']];

        // OPTIONAL : Registrant
        if (!empty($data)) {
            $mappers['{registrant}'] = $data['registrant'];
        }

        return $this->sendRequest('handshake-accept', 'h:hanData', $mappers, [ NominetExtension::STD_HANDSHAKE ]);
    }

    function reject(Array $data)
    {
        $mappers = ['{case_id}' => $data['case_id']];

        return $this->sendRequest('handshake-reject', 'h:hanData', $mappers, [ NominetExtension::STD_HANDSHAKE ]);
    }
}

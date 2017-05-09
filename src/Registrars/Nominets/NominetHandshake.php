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

    private function makeMapper(Array $data)
    {
        return [
            '{case_id}' => $data['case_id'],
            '{registrant}' => $data['registrant']
        ];
    }

    function accept(Array $data)
    {
        $mappers = $this->makeMapper($data);

        return $this->sendRequest('handshake-accept', 'h:hanData', $mappers, [ NominetExtension::STD_HANDSHAKE ]);
    }

    function reject(Array $data)
    {
        $mappers = $this->makeMapper($data);

        return $this->sendRequest('handshake-reject', 'h:hanData', $mappers, [ NominetExtension::STD_HANDSHAKE ]);
    }
}

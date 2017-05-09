<?php

namespace LaravelEPP\Registrars\Nominets;

class NominetFork
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

    public function fork(Array $data)
    {
        $mappers = [
            '{contact_id}' => $data['original_contact_id'],
            '{new_contact_id}' => $data['new_contact_id'],
            '{domain_name}' => $data['domain_names']
        ];

        return $this->sendRequest('fork', 'resData', $mappers, [ NominetExtension::STD_FORK ]);
    }
}

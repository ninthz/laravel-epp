<?php

namespace LaravelEPP\Registrars\Nominets;

/**
 * Type of Lock command
 * http://registrars.nominet.uk/namespace/uk/registration-and-domain-management/epp-commands#Lock
 */
class NominetLockType
{
    /**
     * As part of the requirements for Accredited Channel Partner tags, registrars are responsible for validating their customer data.
     */
    const DATA_QUALITY = 'data quality';

    /**
     * The investigation lock command can be used to lock down a domain name, preventing a number of operations upon it.
     */
    const INVESTIGATION = 'investigation';

    /**
     * The Lock opt-out command can be used to prevent the whois opt-out field being set to 'Y'.
     */
    const OPT_OUT = 'opt-out';

}

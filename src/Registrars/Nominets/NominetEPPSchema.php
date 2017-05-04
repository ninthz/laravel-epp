<?php

namespace LaravelEPP\Registrars\Nominets;

/**
 * Schema for Notminet implementation of Standard EPP
 * Ref: http://registrars.nominet.uk/registration-and-domain-management/schemas-and-namespace-uris
 */
class NominetEPPSchema
{
    /**
     * The base EPP schema.
     */
    const EPP = 'epp-1.0';

    /**
     * Objects for base EPP schema.
     */
    const EPPCOM = 'eppcom-1.0';

    /**
     * Domain schema
     */
    const DOMAIN = 'urn:ietf:params:xml:ns:domain-1.0';

    /**
     * Nameserver schema
     */
    const HOST = 'urn:ietf:params:xml:ns:host-1.0';

    /**
     * Contact schema
     */
    const CONTACT = 'urn:ietf:params:xml:ns:contact-1.0';

    /**
     * DNSSEC
     */
    const SECDNS = 'secDNS-1.1';

    /**
     * This is our custom schema for reseller objects.
     */
    const NOM_RESELLER = 'http://www.nominet.org.uk/epp/xml/nom-reseller-1.0';

    /**
     * This is our custom schema for tag objects.
     */
    const NOM_TAGLIST = 'http://www.nominet.org.uk/epp/xml/nom-tag-1.0';

}

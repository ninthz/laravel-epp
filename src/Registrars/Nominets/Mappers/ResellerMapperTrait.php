<?php


namespace LaravelEPP\Registrars\Nominets\Mappers;


trait ResellerMapperTrait
{
    public $ns_reseller = 'http://www.nominet.org.uk/epp/xml/nom-reseller-1.0';

    public function getListReseller() {
        $listResellers = [];

        $resellers = $this->getElementsByTagName('infData');

        foreach ($resellers as $reseller) {
            $reference = $reseller->getElementsByTagName('reference')[0]->nodeValue ?? null;
            $tradingName = $reseller->getElementsByTagName('tradingName')[0]->nodeValue ?? null;
            $url = $reseller->getElementsByTagName('url')[0]->nodeValue ?? null;
            $email = $reseller->getElementsByTagName('email')[0]->nodeValue ?? null;
            $voice = $reseller->getElementsByTagName('voice')[0]->nodeValue ?? null;
            $listResellers[] = compact('reference', 'tradingName', 'url', 'email', 'voice');
        }

        return $listResellers;
    }
}
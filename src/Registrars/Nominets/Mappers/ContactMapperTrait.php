<?php

namespace LaravelEPP\Registrars\Nominets\Mappers;

trait ContactMapperTrait
{
	public $ns_contact = 'urn:ietf:params:xml:ns:contact-1.0';
	public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0';
	//public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/nom-contact-2.0';

	public function contactInfoMapper() {
		$contact_info = [];
		$contact_info['id'] = $this->GetDataItem($this->ns_contact, 'id');
		$contact_info['roid'] = $this->GetDataItem($this->ns_contact, 'roid');

		foreach($this->getElementsByTagNameNS($this->ns_contact, 'postalInfo') as $postalInfo) {
			$contact_info['name'] = $this->GetDataItem($this->ns_contact, 'name', $postalInfo);
			$contact_info['org'] = $this->GetDataItem($this->ns_contact, 'org', $postalInfo);

			foreach($this->getElementsByTagNameNS($this->ns_contact, 'addr') as $address) {
				$contact_info['street'] = $this->GetDataItem($this->ns_contact, 'street', $address);
				$contact_info['street2'] = $this->GetDataItem($this->ns_contact, 'street', $address, 1);
				$contact_info['street3'] = $this->GetDataItem($this->ns_contact, 'street', $address, 2);
				$contact_info['city'] = $this->GetDataItem($this->ns_contact, 'city', $address);
				$contact_info['sp'] = $this->GetDataItem($this->ns_contact, 'sp', $address);
				$contact_info['pc'] = $this->GetDataItem($this->ns_contact, 'pc', $address);
				$contact_info['cc'] = $this->GetDataItem($this->ns_contact, 'cc', $address);
			}
		}

		$contact_info['voice'] = $this->GetDataItem($this->ns_contact, 'voice');
		$contact_info['email'] = $this->GetDataItem($this->ns_contact, 'email');
		$contact_info['disclose'] = $this->GetDataAttribute($this->ns_contact, 'disclose', 'flag');

		// Nominet extension values
		$contact_info['type'] = $this->GetDataItem($this->ns_contact_ext,'type');
		$contact_info['opt_out'] = $this->GetDataItem($this->ns_contact_ext, 'opt-out');

		return $contact_info;
	}

	public function contactCheckMapper() {
		$contact_info = [];
		$contact_info['id'] = $this->GetDataItem($this->ns_contact, 'id');
		$contact_info['reason'] = $this->GetDataItem($this->ns_contact, 'reason');

		return $contact_info;
	}

	public function contactCreateMapper()
	{
		$contact_info = [];
		$contact_info['id'] = $this->GetDataItem($this->ns_contact, 'id');
		$contact_info['crDate'] = $this->GetDataItem($this->ns_contact, 'crDate');

		return $contact_info;
	}
}
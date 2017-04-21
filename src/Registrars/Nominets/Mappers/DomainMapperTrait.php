<?php

namespace LaravelEPP\Registrars\Nominets\Mappers;

trait DomainMapperTrait
{

	public $ns_domain = 'urn:ietf:params:xml:ns:domain-1.0';
	public $ns_domain_ext = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';
	//public $ns_domain_ext = 'http://www.nominet.org.uk/epp/xml/nom-domain-2.0';

  public function getDomainInfo() {
		$domain_info = [];
		$domain_info['roid'] = $this->getDataItem($this->ns_domain, 'roid');
		$domain_info['domain'] = $this->getDataItem($this->ns_domain,'name');
		$domain_info['reg_status'] = $this->getDataItem($this->ns_domain_ext,'reg-status');
		$domain_info['reseller'] = $this->getDataItem($this->ns_domain_ext,'reseller');
		$domain_info['registrant'] = $this->getDataItem($this->ns_domain, 'registrant');

		$domain_info['account'] = [];
		$domain_info['account']['id'] = $this->getDataItem($this->ns_account,'roid');
		$domain_info['account']['name'] = $this->getDataItem($this->ns_account,'name');
		$domain_info['account']['type'] = $this->getDataItem($this->ns_account,'type');
		$domain_info['account']['opt_out'] = $this->getDataItem($this->ns_account,'opt-out');

		$address = [];
		$address['street'] = $this->getDataItem($this->ns_account,'street');
		$address['city'] = $this->getDataItem($this->ns_account,'city');
		$address['county'] = $this->getDataItem($this->ns_account,'county');
		$address['post_code'] = $this->getDataItem($this->ns_account,'postcode');
		$address['country'] = $this->getDataItem($this->ns_account,'country');

		$domain_info['account']['address'] = $address;
		$domain_info['account']['contact'] = [];

		$i = 0;

		foreach($this->getElementsByTagNameNS($this->ns_account,'contact') as $contact) {
			$domain_info['account']['contact'][$i] = [];
			$domain_info['account']['contact'][$i]['id'] = $this->getDataItem($this->ns_contact,'roid', $contact);
			$domain_info['account']['contact'][$i]['name'] = $this->getDataItem($this->ns_contact,'name', $contact);
			$domain_info['account']['contact'][$i]['phone'] = $this->getDataItem($this->ns_contact,'phone', $contact);
			$domain_info['account']['contact'][$i]['email'] = $this->getDataItem($this->ns_contact,'email', $contact);
			$domain_info['account']['contact'][$i]['tag'] = $this->getDataItem($this->ns_contact,'clID', $contact);
			$domain_info['account']['contact'][$i]['updated_id'] = $this->getDataItem($this->ns_contact,'upID', $contact);
			$domain_info['account']['contact'][$i]['updated_date'] = $this->getDataItem($this->ns_contact,'upDate', $contact);
			$i++;
		}

		$domain_info['account']['tag'] = $this->getDataItem($this->ns_account,'clID');
		$domain_info['account']['creation_id'] = $this->getDataItem($this->ns_account,'crID');
		$domain_info['account']['creation_date'] = $this->getDataItem($this->ns_account,'crDate');
		$domain_info['account']['updated_id'] = $this->getDataItem($this->ns_account,'upID');
		$domain_info['account']['updated_date'] = $this->getDataItem($this->ns_account,'upDate');

		$ns = [];
		$i = 0;

		foreach($this->getElementsByTagNameNS($this->ns_domain,'host') as $host) {
			$ns['host'][$i] = [];
			$ns['host'][$i]['host_name'] = $this->getDataItem($this->ns_domain,'hostName', $host);
			$ns['host'][$i]['host_address'] = $this->getDataItem($this->ns_domain,'hostAddr', $host);
			$ns['host'][$i]['ip_version'] = $this->getDataAttribute($this->ns_domain, 'hostAddr', 'ip', $host);
			$i++;
		}

		$domain_info['ns'] = $ns;
		$domain_info['first_bill'] = $this->getDataItem($this->ns_domain,'first-bill');
		$domain_info['recur_bill'] = $this->getDataItem($this->ns_domain,'recur-bill');
		$domain_info['tag'] = $this->getDataItem($this->ns_domain,'clID');
		$domain_info['creation_id'] = $this->getDataItem($this->ns_domain,'crID');
		$domain_info['creation_date'] = $this->getDataItem($this->ns_domain,'crDate');
		$domain_info['updated_id'] = $this->getDataItem($this->ns_domain,'upID');
		$domain_info['updated_date'] = $this->getDataItem($this->ns_domain,'upDate');
		$domain_info['expiry_date'] = $this->getDataItem($this->ns_domain,'exDate');
		return $domain_info;
	}

	public function getCheckDomain() {
		$domain_info = [];
		$domain_info['name'] = $this->getDataItem($this->ns_domain, 'name');
		$domain_info['reason'] = $this->getDataItem($this->ns_domain, 'reason');

		return $domain_info;
	}
}
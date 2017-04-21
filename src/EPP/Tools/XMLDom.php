<?php
namespace LaravelEPP\Epp\Tools;

class XMLDom extends \DOMDocument {

	public $ns_domain = 'urn:ietf:params:xml:ns:domain-1.0';
	public $ns_domain_ext = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';
	//public $ns_domain_ext = 'http://www.nominet.org.uk/epp/xml/nom-domain-2.0';
	public $ns_account = 'http://www.nominet.org.uk/epp/xml/nom-account-2.0';
	public $ns_contact = 'urn:ietf:params:xml:ns:contact-1.0';
	public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0';
	//public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/nom-contact-2.0';
	public $ns_host = 'urn:ietf:params:xml:ns:host-1.0';

	public function fromMixed($mixed, DOMElement $domElement = null) {
		$domElement = is_null($domElement) ? $this : $domElement;

		if(is_array($mixed)) {
			foreach($mixed as $index => $mixedElement) {
				if(is_int($index)) {
					if($index == 0)
						$node = $domElement;
					else {
						$node = $this->createElement($domElement->tagName);
						$domElement->parentNode->appendChild($node);
					}
				}
				else {
					$node = $this->createElement($index);
					$domElement->appendChild($node);
				}

				if(is_array($mixedElement) && isset($mixedElement['attr'])) {
					foreach($mixedElement['attr'] as $key => $value)
						$node->setAttribute($key, $value);

					$this->fromMixed($mixedElement['body'], $node);
				}
				else
					$this->fromMixed($mixedElement, $node);
			}
		}
		else
			$domElement->appendChild($this->createTextNode($mixed));
	}

	public function getMessage() {
		return $this->getElementsByTagName("msg")->item(0)->nodeValue;
	}

	public function getCode() {
		return $this->getElementsByTagName("result")->item(0)->getAttribute('code');
	}

	public function getReason() {
		return $this->getElementsByTagName("reason")->item(0)->nodeValue;
	}

	public function GetID() {
		return $this->getElementsByTagName("clTRID")->item(0)->nodeValue;
	}

	public function getDataItem($ns, $name, $dom_element = null, $nodeIndex = 0) {
		$dom_element = is_null($dom_element) ? $this : $dom_element;

		if($dom_element->getElementsByTagNameNS($ns, $name)->length > $nodeIndex)
			return $dom_element->getElementsByTagNameNS($ns, $name)->item($nodeIndex)->nodeValue;
		else
			return '';
	}

	public function getDataAttribute($ns, $name, $attribute, $dom_element = null) {
		$dom_element = is_null($dom_element) ? $this : $dom_element;

		if($dom_element->getElementsByTagNameNS($ns, $name)->length > 0) {
			if($dom_element->getElementsByTagNameNS($ns,$name)->item(0)->hasAttribute($attribute))
				return $dom_element->getElementsByTagNameNS($ns,$name)->item(0)->getAttribute($attribute);
			else
				return '';
		}
		else
			return '';
	}

	public function getContactInfo() {
		$contact_info               = [];
		$contact_info['id']					= $this->getDataItem($this->ns_contact, 'id');
		$contact_info['roid']				= $this->getDataItem($this->ns_contact, 'roid');

		foreach($this->getElementsByTagNameNS($this->ns_contact, 'postalInfo') as $postalInfo) {
			$contact_info['name'] 		= $this->getDataItem($this->ns_contact, 'name', $postalInfo);
			$contact_info['org'] 			= $this->getDataItem($this->ns_contact, 'org', $postalInfo);

			foreach($this->getElementsByTagNameNS($this->ns_contact, 'addr') as $address) {
				$contact_info['street'] 	= $this->getDataItem($this->ns_contact, 'street', $address);
				$contact_info['street2'] 	= $this->getDataItem($this->ns_contact, 'street', $address, 1);
				$contact_info['street3'] 	= $this->getDataItem($this->ns_contact, 'street', $address, 2);
				$contact_info['city'] 		= $this->getDataItem($this->ns_contact, 'city', $address);
				$contact_info['sp'] 			= $this->getDataItem($this->ns_contact, 'sp', $address);
				$contact_info['pc'] 			= $this->getDataItem($this->ns_contact, 'pc', $address);
				$contact_info['cc']	 			= $this->getDataItem($this->ns_contact, 'cc', $address);
			}
		}

		$contact_info['voice'] 			= $this->getDataItem($this->ns_contact, 'voice');
		$contact_info['email'] 			= $this->getDataItem($this->ns_contact, 'email');
		$contact_info['disclose'] 	= $this->getDataAttribute($this->ns_contact, 'disclose', 'flag');

		// Nominet extension values
		$contact_info['type'] 			= $this->getDataItem($this->ns_contact_ext,'type');
		$contact_info['opt_out']		= $this->getDataItem($this->ns_contact_ext, 'opt-out');

		return $contact_info;
	}

	public function getCheckContact() {
		$contact_info = [];
		$contact_info['id'] = $this->getDataItem($this->ns_contact, 'id');
		$contact_info['reason'] = $this->getDataItem($this->ns_contact, 'reason');

		return $contact_info;
	}

	public function getDomainInfo() {
		$domain_info 								  = [];
		$domain_info['roid'] 					= $this->getDataItem($this->ns_domain, 'roid');
		$domain_info['domain'] 				= $this->getDataItem($this->ns_domain,'name');
		$domain_info['reg_status'] 		= $this->getDataItem($this->ns_domain_ext,'reg-status');
		$domain_info['reseller'] 		= $this->getDataItem($this->ns_domain_ext,'reseller');
		$domain_info['registrant'] 		= $this->getDataItem($this->ns_domain, 'registrant');

		$domain_info['account'] 					  = [];
		$domain_info['account']['id'] 			= $this->getDataItem($this->ns_account,'roid');
		$domain_info['account']['name'] 		= $this->getDataItem($this->ns_account,'name');
		$domain_info['account']['type'] 		= $this->getDataItem($this->ns_account,'type');
		$domain_info['account']['opt_out'] 	= $this->getDataItem($this->ns_account,'opt-out');

		$address               = [];
		$address['street']     = $this->getDataItem($this->ns_account,'street');
		$address['city']       = $this->getDataItem($this->ns_account,'city');
		$address['county']     = $this->getDataItem($this->ns_account,'county');
		$address['post_code']  = $this->getDataItem($this->ns_account,'postcode');
		$address['country']    = $this->getDataItem($this->ns_account,'country');

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

	public function getCheckHost() {
		$host_info = [];
		$host_info['name'] = $this->getDataItem($this->ns_host, 'name');
		$host_info['reason'] = $this->getDataItem($this->ns_host, 'reason');

		return $host_info;
	}
}

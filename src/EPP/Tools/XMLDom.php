<?php

namespace LaravelEPP\Epp\Tools;

use LaravelEPP\Registrars\Nominets\Mappers\DomainMapperTrait;
use LaravelEPP\Registrars\Nominets\Mappers\ContactMapperTrait;
use LaravelEPP\Registrars\Nominets\Mappers\HostMapperTrait;

class XMLDom extends \DOMDocument {

	use DomainMapperTrait, ContactMapperTrait, HostMapperTrait;

	public $ns_account = 'http://www.nominet.org.uk/epp/xml/nom-account-2.0';
	public $ns_contact = 'urn:ietf:params:xml:ns:contact-1.0';
	public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.0';
	//public $ns_contact_ext = 'http://www.nominet.org.uk/epp/xml/nom-contact-2.0';

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
		return $this->getElementsByTagName("reason")->item(0)->nodeValue ?? '';
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
		$dom_element = $this->getDomElement($dom_element);

		if($dom_element->getElementsByTagNameNS($ns, $name)->length > 0) {
			if($dom_element->getElementsByTagNameNS($ns,$name)->item(0)->hasAttribute($attribute))
				return $dom_element->getElementsByTagNameNS($ns,$name)->item(0)->getAttribute($attribute);
			else
				return '';
		}
		else
			return '';
	}

	public function getDomElement($domElement = null)
    {
        return is_null($domElement) ? $this : $domElement;
    }

    /**
     * Sometimes Nominet return the element in array format, we need to get the length and loop through them
     * @param string $ns
     * @param string $property
     * @param null $domElement
     * @return array
     */
    public function getArrayElementsResponse($ns, $property, $domElement = null)
    {
        $domElement = $this->getDomElement($domElement);
        $length = $domElement->getElementsByTagNameNS($ns, $property)->length;

        $result = [];
        for ($i = 0; $i < $length; $i++) {
            $result[] = $this->getDataItem($ns, $property, null, $i);
        }
        return $result;
    }
}

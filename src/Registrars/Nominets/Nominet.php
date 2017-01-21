<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;

/**
 * Nominet Base Class
 */
class Nominet
{
  protected $epp_client;
  protected $host = 'epp.nominet.org.uk';
  protected $port = 700;
  protected $timeout = 1;
  protected $protocol = 'ssl';

  protected $username = '';
  protected $password = '';
  protected $test_mode = false;
  protected $data_xml_path;

  function __construct()
  {
    if(function_exists('config'))
    {
        $this->test_mode  = config('epp.nominet.testmode', false);
        $this->port       = config('epp.nominet.port');
        $this->timeout    = config('epp.nominet.timeout');
        $this->protocol   = config('epp.nominet.protocol');

        $mode = ($this->test_mode ? 'live' : 'test');
        $this->host = config("epp.nominet.${mode}.host");
        $this->username = config("epp.nominet.${mode}.username");
        $this->password = config("epp.nominet.${mode}.password");
    }
    $this->epp_client = new EppClient($this->host);
    $this->data_xml_path = __DIR__.'/DataXML/';
  }

  public function __destruct()
  {
    $this->epp_client->disconnect();
  }

  public function setUsername($username)
  {
    $this->username = $username;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setDataXMLPath($path)
  {
    $this->data_xml_path = $path;
  }

  public function setHost($host)
  {
    $this->epp_client->disconnect();
    $this->epp_client->setHost($host);
    $this->epp_client->connect();
  }

  public function getHost()
  {
    return $this->epp_client->getHost();
  }


  public function getDataXMLPath($filename = '')
  {
    if ($filename != '')
      $filename .= '.xml';
    return $this->data_xml_path.$filename;
  }

  public function login($reseller_access = false)
  {
    $xml = file_get_contents($this->getDataXMLPath('login'));
    if ($reseller_access)
      $xml = file_get_contents($this->getDataXMLPath('login-reseller-access'));

    $mappers = [
      '{clID}'  => $this->getUsername(),
      '{pw}'    => $this->getPassword()
    ];
    $xml = $this->mapParameters($xml, $mappers);
    $response =  $this->epp_client->sendRequest($xml);
    return $response["status"];
  }

  public function logout()
  {
    $xml = file_get_contents($this->getDataXMLPath('logout'));
    return $this->epp_client->sendRequest($xml);
  }

  public function mapParameters($xml_template, $mappers)
  {
    $markers  = array_keys($mappers);
    $values   = array_values($mappers);
    return str_replace($markers, $values, $xml_template);
  }
}

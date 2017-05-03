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

  protected $logged_in = false;

  const LOGIN_DEFAULT = 'login';
  const LOGIN_RESELLER = 'login-reseller-access';
  const LOGIN_LIST = [
    self::LOGIN_DEFAULT,
    self::LOGIN_RESELLER,
  ];

  function __construct()
  {
    if(function_exists('config'))
    {
        $this->test_mode  = config('epp.nominet.testmode', false);
        $this->port       = config('epp.nominet.port');
        $this->timeout    = config('epp.nominet.timeout');
        $this->protocol   = config('epp.nominet.protocol');

        $mode = ($this->test_mode ? 'test' : 'live');
        $this->host = config("epp.nominet.${mode}.host");
        $this->username = config("epp.nominet.${mode}.username");
        $this->password = config("epp.nominet.${mode}.password");
    }
    $this->epp_client = new EppClient($this->host);
    $this->data_xml_path = __DIR__.'/DataXML/';
  }

  public function __destruct()
  {
    if ($this->logged_in)
      $this->logout();
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

  public function getXmlResponse()
  {
    return $this->epp_client->getXmlResponse();
  }

  public function getXmlRequest()
  {
    return $this->epp_client->getXmlRequest();
  }

  public function getDataXMLPath($filename = '')
  {
    if ($filename != '')
      $filename .= '.xml';
    return $this->data_xml_path.$filename;
  }

  public function login($loginType = self::LOGIN_DEFAULT)
  {
    if (!in_array($loginType, self::LOGIN_LIST))
        throw new \Exception("Invalid argument loginType.");

    $xml = file_get_contents($this->getDataXMLPath($loginType));

    $mappers = [
      '{clID}'  => $this->getUsername(),
      '{pw}'    => $this->getPassword()
    ];

    $xml = $this->mapParameters($xml, $mappers);
    $response =  $this->epp_client->sendRequest($xml)->toJson();

    if ($response->status)
      $this->logged_id = true;

    return $response->status;
  }

  public function logout()
  {
    $xml = file_get_contents($this->getDataXMLPath('logout'));
    $response = $this->epp_client->sendRequest($xml)->toJson();
    if ($response->status)
      $this->logged_in = false;
    return $response;
  }

  private function replaceArrayXmlParams(String $xml, String $replaceKey, Array $values): String
  {
    $startAt = strpos($xml, "{[");
    $endAt = strpos($xml, "]}");

    $templateText = substr($xml, $startAt, $endAt - $startAt);
    $templateText = str_replace("{[", "", $templateText);
    $templateText = str_replace("]}", "", $templateText);

    if (strpos($templateText, $replaceKey))
    {
      $text = "";
      foreach ($values as $key => $value) {
        $text .= str_replace($replaceKey, $value, $templateText);
        $text .= "\n";
      }

      $xml = substr($xml, 0, $startAt) . $text . substr($xml, $endAt + 2);
    }

    return $xml;
  }

  public function mapParameters(String $xml, $mappers): String
  {
    foreach ($mappers as $mapperKey => $mapperValue) {
      if (is_array($mapperValue))
      {
        $xml = $this->replaceArrayXmlParams($xml, $mapperKey, $mapperValue);
      }
      else
      {
        $xml = str_replace($mapperKey, $mapperValue, $xml);
      }
    }

    return $xml;
  }
}

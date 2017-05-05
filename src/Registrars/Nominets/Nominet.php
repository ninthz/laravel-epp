<?php

namespace LaravelEPP\Registrars\Nominets;

use LaravelEPP\EPP\EppClient;
use LaravelEPP\EPP\Exceptions\UnableToLoginException;
use LaravelEPP\EPP\Tools\XmlUtility;

/**
 * Nominet Base Class
 */
class Nominet
{
    protected $epp_client;
    protected $xmlUtility;

    protected $host = 'epp.nominet.org.uk';
    protected $port = 700;
    protected $timeout = 1;
    protected $protocol = 'ssl';

    protected $username = '';
    protected $password = '';
    protected $test_mode = false;
    protected $data_xml_path;

    protected $logged_in = false;
    protected $extensions = [];

    const GENERAL_ACCESS = 'ga';
    const RESELLER_ACCESS = 'ra';
    const TAGLIST_ACCESS = 'ta';
    const HOST_ACCESS = 'ha';

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
        $this->xmlUtility = new XmlUtility();
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

    public function login($loginType = self::GENERAL_ACCESS)
    {
        $templateName = 'login';
        $mappers = [
          '{clID}'  => $this->getUsername(),
          '{pw}'    => $this->getPassword(),
          '{schema}' => [],
          '{extensions}' => $this->extensions
        ];

        # Setting Schema
        if ($loginType === self::GENERAL_ACCESS) {
            $mappers['{schema}'] = [
                NominetEPPSchema::DOMAIN,
                NominetEPPSchema::CONTACT
            ];
        } else if ($loginType === self::RESELLER_ACCESS) {
            $mappers['{schema}'] = [
                NominetEPPSchema::NOM_RESELLER
            ];
        } else if ($loginType === self::TAGLIST_ACCESS) {
            $mappers['{schema}'] = [
                NominetEPPSchema::NOM_TAGLIST
            ];
        } else if ($loginType === self::HOST_ACCESS) {
            $mappers['{schema}'] = [
                NominetEPPSchema::HOST
            ];
        } else {
            throw new \Exception("Invalid argument loginType.");
        }

        $xml = file_get_contents($this->getDataXMLPath($templateName));

        $xml = $this->mapParameters($xml, $mappers);

        $response = $this->epp_client->sendRequest($xml);
        $response = $this->parseXmlResponse($response->getXmlResponse(), 'resData', 'result');

        if ($response['status'])
            $this->logged_id = true;

        return $response['status'];
    }

    public function parseXmlResponse(String $xml, bool $namespace = false): Array
    {
        $response = $this->xmlUtility->parseXmlResponse($xml, 'resData', 'result', $namespace);

        $response['status']['status'] = $response['status']['code'] == 1000 || $response['status']['code'] == 1500;

        return $response;
    }

    public function logout()
    {
        $xml = file_get_contents($this->getDataXMLPath('logout'));

        $response = $this->epp_client->sendRequest($xml);
        $response = $this->parseXmlResponse($response->getXmlResponse(), 'resData', 'result');

        if ($response['status'])
            $this->logged_in = false;
        return $response;
    }

    private function replaceArrayXmlParams(String $xml, String $replaceKey, Array $values): String
    {
        $regexArrayTemplate = "/{\[.*]}/";
        $regexKey = "/{\w*}/";
        preg_match_all($regexArrayTemplate, $xml, $matches);

        foreach ($matches[0] as $key => $templateText) {
            if (strpos($templateText, $replaceKey) !== false)
            {

                $firstPart = substr($xml, 0, strpos($xml, $templateText));

                $lastPart = substr($xml, strpos($xml, $templateText));

                if (strpos($templateText, $replaceKey))
                {
                    $text = "";
                    foreach ($values as $key => $value) {
                        $text .= substr(str_replace($replaceKey, $value, $templateText), 2, -2);
                        $text .= "\n";
                    }

                    $xml = $firstPart . $text . $lastPart;
                }

                $xml = str_replace($templateText, "", $xml);
                break;
            }
        }
        return $xml;
    }

    private function removeEmptyOptionalTag(String $xml, $mappers): String
    {
        $totalOptionalTags = substr_count($xml, "{?");

        $regex = '/{\w*}/';

        for ($i = 0; $i < $totalOptionalTags; $i++)
        {
            $templateKeys = [];
            $startAt = strpos($xml, "{?");
            $endAt = strpos($xml, "?}") + 2;

            $templateText = substr($xml, $startAt, $endAt - $startAt);

            $totalParamTagInsideOptional = substr_count($templateText, "{");

            preg_match_all($regex, $templateText, $matches);

            foreach ($matches[0] as $key => $value) {
                $templateKeys[] = substr($value, 1, -1);
            }

            $isEmpty = true;

            foreach ($templateKeys as $key => $value) {
                $tempKey = "{" . $value . "}";
                if (isset($mappers[$tempKey]) && gettype($mappers[$tempKey]) == 'string' && $mappers[$tempKey] != '')
                {
                    $isEmpty = false;
                }
                else if (isset($mappers[$tempKey]) && is_array($mappers[$tempKey]) && count($mappers[$tempKey]) != 0)
                {
                    $isEmpty = false;
                }
                else {
                    $endFirstPart = substr($templateText, 0, strrpos($templateText, $tempKey));
                    $firstPart = substr($endFirstPart, 0, strrpos($endFirstPart, "<"));

                    $startLastPart = substr($templateText, strrpos($templateText, $tempKey));
                    $lastPart = substr($startLastPart, strpos($startLastPart, ">") + 1);

                    $templateText = $firstPart . "\n" . $lastPart;
                }

                $newXml = substr($xml, 0, $startAt) . $templateText . substr($xml, $endAt);
            }

                $endAt = strpos($xml, "?}");
            if ($isEmpty)
            {
                $xml = substr($xml, 0, $startAt) . substr($xml, $endAt + 2);
            }
            else
            {
                $startAt = strpos($newXml, "{?");
                $endAt = strpos($newXml, "?}");
                $templateXml = substr($newXml, $startAt + 2, $endAt - $startAt - 2);
                $xml = substr($newXml, 0, $startAt) . $templateXml . substr($newXml, $endAt + 2);
            }
        }

        return $xml;
    }

    public function mapParameters(String $xml, $mappers): String
    {
        $xml = $this->removeEmptyOptionalTag($xml, $mappers);
        foreach ($mappers as $mapperKey => $mapperValue) {
            if (is_array($mapperValue))
                $xml = $this->replaceArrayXmlParams($xml, $mapperKey, $mapperValue);
            else
                $xml = str_replace($mapperKey, $mapperValue, $xml);
        }

        return $xml;
    }

    /**
     * Get the value of Extensions
     *
     * @return mixed
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Set the value of Extensions
     *
     * @param mixed extensions
     *
     * @return self
     */
    public function setExtensions($extensions)
    {
        $this->extensions = array_merge($this->extensions, $extensions);

        return $this;
    }

    /**
     * Send the request to Nominet
     * @param string $xmlFileName
     * @param array $mappers
     * @param array $extensions
     * @return EppClient|Nominet
     * @throws UnableToLoginException
     */
    public function sendRequest($xmlFileName, $mappers = [], $extensions = [], String $loginType = Nominet::GENERAL_ACCESS)
    {
        $this->setExtensions($extensions);

        // Throw an error if can't connect to Nominet
        if(! $this->login($loginType)) throw new UnableToLoginException('Unable to login to Nominet');

        // Map the file and mappers
        $xml = file_get_contents($this->getDataXMLPath($xmlFileName));
        $xml = $this->mapParameters($xml, $mappers);

        $response = $this->epp_client->sendRequest($xml);

        return $this->parseXmlResponse($response->getXmlResponse(), 'resData', 'result');
    }

}

<?php

namespace LaravelEPP\EPP;

use LaravelEPP\EPP\Exceptions\EppException;
use LaravelEPP\EPP\Tools\XMLDom;

/**
 * The class that use connect with EPP
 */
class EppClient
{
    private $socket;
    private $host;
    private $port;
    private $timeout;
    private $protocol;
    private $clTRID = '';
    private $xmlResponse;
    private $xmlRequest;
    private $response = [];

    public function __construct($host, $port = 700, $timeout = 30, $protocol = 'ssl')
    {
      $this->xmlRequest = new \DOMDocument();
      $this->host = $host;
      $this->port = $port;
      $this->timeout = $timeout;
      $this->protocol = $protocol;
      $this->connect();
    }

    public function setHost($host)
    {
      $this->host = $host;
    }

    public function getHost()
    {
      return $this->host;
    }

    public function setPort($port)
    {
      $this->port = $port;
    }

    public function getPort()
    {
      return $this->port;
    }

    public function setTimeout($timeout)
    {
      $this->timeout = $timeout;
    }

    public function getTimeout()
    {
      return $this->timeout;
    }

    public function setProtocol($protocol)
    {
      $this->protocol = $protocol;
    }

    public function getProtocol()
    {
      return $this->protocol;
    }

    public function connect()
    {
      $target = sprintf('%s://%s:%d', $this->protocol, $this->host, $this->port);
      $context = stream_context_create();
      $this->socket = stream_socket_client($target, $errno, $errstr, $this->timeout, STREAM_CLIENT_CONNECT, $context);
      if (!$this->socket) {
        throw new EppException("Error connecting to $target: $errstr (code $errno)", $errno, null, $errstr);
      }
      return $this->read();
    }

    public function disconnect() {
      if (is_resource($this->socket)) {
          fclose($this->socket);
      }
      return true;
    }

    public function read()
    {
      if($this->socket !== FALSE) {
        if(@feof($this->socket))
          return new EppException('connection closed by remote server');

        $hdr = @fread($this->socket, 4);

        if (empty($hdr) && feof($this->socket))
          return new EppException('connection closed by remote server');

        if (empty($hdr))
          return new EppException('Error reading from server');

        $unpacked 	= unpack('N', $hdr);
        $length 	= $unpacked[1];

        if($length < 5)
          return new EppException('Got a bad frame header length of '.$length.' bytes from server');

        return fread($this->socket, ($length - 4));
      }
    }

    public function sendRequest($xml)
    {
      $this->clTRID = $this->generateRandomString(32);

      $this->xmlRequest->loadXML(str_replace('{clTRID}', $this->clTRID, $xml));

      if ($this->socket !== FALSE)
        fwrite($this->socket, $this->getXmlRequest());

      $this->xmlResponse = $this->read();

      // $this->parseResponse();

      return $this;
    }

    private function parseResponse() {
      $dom = new XMLDom();

      $dom->loadXML($this->xmlResponse);

      if(($dom->getCode() != 1000) && ($dom->getCode() != 1500))
        $this->response = ["status" => false, "message" => 'Error: '.$dom->getMessage(), 'code' => $dom->getCode(), 'reason' => $dom->getReason()];
      else
        $this->response = ["status" => true, "message" => $dom->getMessage(), "dom" => $dom];
    }

    private function generateRandomString($length) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }


    /**
     * Get the value of Xml Response
     *
     * @return mixed
     */
    public function getXmlResponse()
    {
        return $this->xmlResponse;
    }

    /**
     * Get the value of Xml Request
     *
     * @return mixed
     */
    public function getXmlRequest()
    {
        return $this->xmlRequest->saveXML();
    }

    public function toArray()
    {
        return $this->response;
    }

    public function toJson()
    {
        return (object) $this->response;
    }
}

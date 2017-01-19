<?php

namespace LaravelEPP\EPP;

use LaravelEPP\EPP\Exceptions\EppException;

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

  public function __construct($host, $port = 700, $timeout = 1, $protocol = 'ssl')
  {
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

  public function sendRequest($xml_template)
  {
    if($this->socket !== FALSE)
      fwrite($this->socket, pack('N', (strlen($xml_template)+4)).$xml_template);
    return parseResponse($this->read());
  }

  public function parseResponse($response, $rand_id = '') {
    $dom = new XMLDOM();
    $dom->loadXML($response);

    if(($dom->GetCode() != 1000) && ($dom->GetCode() != 1500))
      return array("status" => false, "message" => 'Error: '.$dom->GetMessage());
    else if(($dom->GetID() != $rand_id) && ($rand_id != ''))
      return array("status" => false, "message" => 'Error: Invalid return code. ID Sent: EPP-'.$rand_id.' - ID Received: '.$dom->GetID());
    else
      return array("status" => true, "message" => $dom->GetMessage(), "dom" => $dom);
  }

}

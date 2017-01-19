<?php
return [
  "nominet" => [
    "live" => [
      "host" => env('NOMINET_LIVE_HOST', 'epp.nominet.org.uk'),
      "username" => env('NOMINET_LIVE_USERNAME', ''),
      "password" => env('NOMINET_LIVE_PASSWORD', ''),
    ],
    "test" => [
      "host" => env('NOMINET_TEST_HOST', 'testbed-epp.nominet.org.uk'),
      "username" => env('NOMINET_TEST_USERNAME', ''),
      "password" => env('NOMINET_TEST_PASSWORD', ''),
    ],
    "port" => "700",
    "timeout" => "1",
    "protocol" => "ssl",
    "testmode" => env('NOMINET_TESTMODE', true)
  ]
];

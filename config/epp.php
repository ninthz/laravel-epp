<?php
return [

    /**
     * Nominet settings
     */
    "nominet" => [
        "live"     => [
            "host"     => env('NOMINET_LIVE_HOST', 'epp.nominet.org.uk'),
            "username" => env('NOMINET_LIVE_USERNAME', ''),
            "password" => env('NOMINET_LIVE_PASSWORD', ''),
        ],
        "test"     => [
            "host"     => env('NOMINET_TEST_HOST', 'testbed-epp.nominet.org.uk'),
            "username" => env('NOMINET_TEST_USERNAME', ''),
            "password" => env('NOMINET_TEST_PASSWORD', ''),
        ],
        "port"     => "700",
        "timeout"  => "1",
        "protocol" => "ssl",
        "testmode" => env('NOMINET_TESTMODE', true),
    ],

    /**
     * Verisign settings
     */
    "verisign" => [
        "live" => [
            "host" => env('VERISIGN_LIVE_HOST', 'epp-ote.verisign-grs.com'),
            "username" => env('VERISIGN_LIVE_USERNAME', ''),
            "password" => env('VERISIGN_LIVE_PASSWORD', ''),
        ],
        "test" => [
            "host" => env('VERISIGN_TEST_HOST', 'epp-ote.verisign-grs.com'),
            "username" => env('VERISIGN_TEST_USERNAME', ''),
            "password" => env('VERISIGN_TEST_PASSWORD', ''),
        ],
        "port" => "700",
        "timeout" => "1",
        "protocol" => "ssl",
        "testmode" => env('VERISIGN_TESTMODE', true)
    ]
];

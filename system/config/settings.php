<?php
$env = (getenv("APP_ENV") == "development" ? true : false);
return [
    'settings' => [
        'displayErrorDetails' => $env, // set to false in production

        // Database berrybenka
        "dbberrybenka" => [
            "host" => getenv("MYSQL_HOST"),
            "dbname" => getenv("DB_BERRYBENKA"),
            "user" => getenv("MYSQL_USERNAME"),
            "pass" => getenv("MYSQL_PASSWORD")
        ],
 
       // Database Berrybenka WMS
        "dbberrybenka_wms" => [
            "host" => getenv("MYSQL_HOST"),
            "dbname" => getenv("DB_WMS"),
            "user" => getenv("MYSQL_USERNAME"),
            "pass" => getenv("MYSQL_PASSWORD")
        ],

        // Redis
        "redis" => [
            "schema" => "tcp",
            "host" => getenv("REDIS_HOST"),
            "port" => getenv("REDIS_PORT")
        ],

        'hmvc' => [
            'modulePath' => APPPATH . SKELETON . DIRECTORY_SEPARATOR,
        ],
    ],
];
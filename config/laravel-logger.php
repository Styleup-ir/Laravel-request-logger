<?php

return [


    'drivers' => [

        'default' => [
            'enable' => env('STP_LOGGER_ENABLE',true),
            // Connection key Driver For Database MongoDB In Config DataBase
            'connection' => env('STP_LOGGER_CONNECTION_DATABASE','mongodb'),
            'collection' => env('STP_LOGGER_COLLECTION','test'),
            'guard' => env('STP_LOGGER_GUARD_AUTH','web'),
        ],


//        'example1' => [
//            'enable' => env('STP_LOGGER_ENABLE',true),
//            // Connection key Driver For Database MongoDB In Config DataBase
//            'connection' => env('STP_LOGGER_CONNECTION_DATABASE','mongodb'),
//            'collection' => env('STP_LOGGER_COLLECTION','exmaple1'),
//            'guard' => env('STP_LOGGER_GUARD_AUTH','web'),
//        ],

    ]

];

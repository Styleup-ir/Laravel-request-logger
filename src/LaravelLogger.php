<?php

namespace Styleup\LaravelLogger;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isJson;

class LaravelLogger
{
    public static function createGUID(){
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }

    public static function storeRequest($guid,$request,$driver = 'default'){

        $connection =  config('laravel-logger.drivers.'.$driver.'.connection');
        $collection =  config('laravel-logger.drivers.'.$driver.'.collection');
        $auth_guard =  config('laravel-logger.drivers.'.$driver.'.guard');



        DB::connection($connection)->collection($collection)
            ->insert([
                'request_id' => $guid,
                'request_user' => auth()->user($auth_guard) ? auth($auth_guard)->user()->id : $request->ip(),
                'request_url' => $request->getUri(),
                'request_method' => $request->getMethod(),
                'request_header' => $request->header(),
                'request_body' => $request->all(),
                'response_body' => null,
                'response_status_code' => null,
                'request_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'response_at' => null,
                'complete' => false,
            ]);

    }

    public static function updateRequest($guid,$res_body,$res_code,$driver = 'default'){

        $connection =  config('laravel-logger.drivers.'.$driver.'.connection');
        $collection =  config('laravel-logger.drivers.'.$driver.'.collection');
        $auth_guard =  config('laravel-logger.drivers.'.$driver.'.guard');

        $content = isJson($res_body) ? json_decode($res_body) : $res_body;

        DB::connection($connection)
            ->collection($collection)
            ->where('request_id',$guid)
            ->update([
                'response_body' => $content,
                'response_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'response_status_code' => $res_code,
                'complete' => true,
            ]);
    }

}

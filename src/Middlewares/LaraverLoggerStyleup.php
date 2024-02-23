<?php

namespace Styleup\LaravelLogger\Middlewares;


use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Styleup\LaravelLogger\LaravelLogger;
use function PHPUnit\Framework\isJson;


class LaraverLoggerStyleup
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next,$driver = "default") {

        if(config('laravel-logger.drivers'.$driver.'.enable') === false) {
            return $next($request);
        }

        $guid = LaravelLogger::createGUID();



        LaravelLogger::storeRequest($guid,$request,$driver);


        $response = $next($request);


        LaravelLogger::updateRequest($guid,$response->getContent(),$response->getStatusCode(),$driver);

         return $response;
    }




}

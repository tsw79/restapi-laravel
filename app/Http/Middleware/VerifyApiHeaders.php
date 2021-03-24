<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as BaseHttpResponse;

class VerifyApiHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('accept') !== 'application/vnd.api+json') {
            return new Response('', 406);
        }

        // Only check Content-Type headers for POST and PUT requests
        if($request->isMethod('POST') || $request->isMethod('PUT')) {
            if($request->header('content-type') !== 'application/vnd.api+json') {
                return new Response('', 415);
            }
        }

        return $this->addValidContentType($next($request));
    }

    private function addValidContentType(BaseHttpResponse $response)
    {
        $response->headers->set('content-type', 'application/vnd.api+json');
        return $response;
    }
}

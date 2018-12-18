<?php

namespace App\Http\Middleware;

use Closure;

class content_length
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (headers_sent() || ob_get_contents() != '') return $response;

        $content = $response->content();
        $contentLength = strlen($content);
        $response->header('Content-Length', $contentLength);

        return $response;
//        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    Log::info('Incoming request', [
      'path' => $request->path(),
      'method' => $request->method(),
      'headers' => $request->headers->all(),
      'body' => $request->all(),
    ]);

    return $next($request);
  }
}

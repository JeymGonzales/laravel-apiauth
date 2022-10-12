<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class BearerToken
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
        $bToken = $request->bearerToken();

        if($bToken != "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vYXBpYXV0aGxhcmF2ZWwudGVzdC9hcGkvbG9naW4iLCJpYXQiOjE2NjQxNzU4NDQsImV4cCI6MTY2NDE3OTQ0NCwibmJmIjoxNjY0MTc1ODQ0LCJqdGkiOiJlU3ZoeTNqaXdqVXNTcFhsIiwic3ViIjoiMSIsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.Cpg9kDjtCkhqm9nhLGrtoVEfMo-javYDp8O-bNKytec"){
           
            $response = $next($request);
            $response->headers->remove('Authorization');
            return redirect('/');
        }
        else{
            
        }

        return $next($request);
    }
}

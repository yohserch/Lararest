<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        // $transformedInput = [];

        // foreach ($request->request->all() as $input => $value) {
        //     $transformedInput[$transformer::originalAttribute($input)] = $value;
        // }
        
        // $request->replace($transformedInput);

        return $next($request);
    }
}

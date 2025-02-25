<?php

namespace Laramin\Utility;

use Closure;

class Utility{

    public function handle($request, Closure $next)
    {
    	//raz0r clear
        return $next($request);
    }
}

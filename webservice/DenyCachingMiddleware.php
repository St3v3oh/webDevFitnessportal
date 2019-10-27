<?php
  class DenyCachingMiddleware
  {
      public function __invoke($request, $response, $next)
      {
        $response = $response->withHeader("Cache-Control", "no-cache, no-store, must-revalidate");
        return $next($request, $response);
      }    
  }
?>
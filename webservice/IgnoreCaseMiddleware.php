<?php
  class IgnoreCaseMiddleware
  {
      public function __invoke($request, $response, $next)
      {
        $uri = $request->getUri();
        $uri = $uri->withPath(strtolower($uri->getPath()));
        $request = $request->withUri($uri);
        return $next($request, $response);
      }    
  }
?>
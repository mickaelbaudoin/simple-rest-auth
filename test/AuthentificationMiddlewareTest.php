<?php

namespace MB\SimpleRestAuthTest;

use PHPUnit\Framework\TestCase;

class AuthentificationMiddlewareTest extends TestCase{
    
    public function testAuthentificationSuccess(){
        $header = array();
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', 'https://localhost/auth/login/test/password/123456', $header);
        $request = $request->withAttribute('login', 'test');
        $request = $request->withAttribute('password', '123456');
        
        $response = new \GuzzleHttp\Psr7\Response();
        $callback = function() use ($response) {return $response;};
        
        $userService = new Mocks\UserServiceMock();
        $middleware = new \MB\SimpleRestAuth\AuthentificationMidleware($userService);
        $reponseServer = $middleware($request,$response,$callback);
        
        $this->assertEquals(200, $reponseServer->getStatusCode());
    }
    
    public function testAuthentificationFailed(){
        $header = array();
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', 'https://localhost/auth/login/test/password/123456', $header);
        $request = $request->withAttribute('login', 'test');
        $request = $request->withAttribute('password', '');
        
        $response = new \GuzzleHttp\Psr7\Response();
        $callback = function() use ($response) {return $response;};
        
        $userService = new Mocks\UserServiceMock();
        $middleware = new \MB\SimpleRestAuth\AuthentificationMidleware($userService);
        $reponseServer = $middleware($request,$response,$callback);
        
        $this->assertEquals(401, $reponseServer->getStatusCode());
    }
}
    
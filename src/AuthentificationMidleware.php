<?php

namespace SimpleRestAuth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of RestAuth
 *
 * @author mickael
 */
class AuthentificationMidleware {
    
    /**
     *
     * @var \Lib\Auth\IUserService
     */
    private $userService = null;
    
    public function __construct(IUserService $userService) {
        $this->userService = $userService;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next){
        $user = $this->findUser($request);
        if($user == null){
            $result = array('message' => 'login or password is not correct');
            $response = $response->withStatus(401);
        }else{
            $result = array('message' => 'login succes', 'token' => $user->getToken());
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    protected function findUser(ServerRequestInterface $request){
        $user = $this->userService->findUserByFilters($request);
        if($user instanceof \Lib\Auth\IUser){  
            $user->setToken($this->userService->generateToken());
            return $user;
        }
        
        return null;
    }
}

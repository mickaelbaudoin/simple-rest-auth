<?php

namespace SimpleRestAuthTest\Mocks;

class UserServiceMock implements \SimpleRestAuth\IUserService{
    
    private $login = "test";
    private $password = "123456";
    
    public function findUserByFilters(\Psr\Http\Message\ServerRequestInterface $request) {
        $login = $request->getAttribute('login');
        $password = $request->getAttribute('password');
        
        if($login == $this->login && $password == $this->password){
            $user = new \SimpleRestAuthTest\Mocks\UserMock();
            return $user;
        }
        return null;
    }

    public function generateToken(\SimpleRestAuth\IUser $user) {
        return $user;
    }

}
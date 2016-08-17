## synospis
Authentication API REST

## Code example

### Step 1 - Create UserEntity and UserService

```
namespace Foo\Entity;

class UserEntity implements \MB\SimpleRestAuth\IUser{
    
    public function getGroups() {
        return [];
    }
    
    public function getLogin() {
        return 'test';
    }
    
    public function getToken() {
        return 'DKS827HDKLSC782';
    }
    
    public function getTokenDateExpired() {
        
    }
    
    public function getUserId() {
        return 1;
    }
    
    public function setToken($token) {
        
    }
}

namespace Foo\Service;

class UserService implements \MB\SimpleRestAuth\IUserService{
    
    private $login = "test";
    private $password = "123456";
    
    public function findUserByFilters(\Psr\Http\Message\ServerRequestInterface $request) {
        $login = $request->getAttribute('login');
        $password = $request->getAttribute('password');
        
        if($login == $this->login && $password == $this->password){
            $user = new UserEntity();
            return $user;
        }
        return null;
    }
    public function generateToken(\MB\SimpleRestAuth\IUser $user) {
        return $user;
    }
}
```

### Step 2 - Configuring Factories and Middlewares

#### With zend-expressive

index.php
```
<?php

use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

// Load configuration
$config = require __DIR__ . '/config.php';
// Build container
$container = new ServiceManager();

//Authentification
$container->setService("IUserService", new \Lib\AuthImpl\UserService());

//Config
(new Config($config['dependencies']))->configureServiceManager($container);
// Inject config
$container->setService('config', $config);
return $container;
```

routes.global.php
```
<?php
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;
return [
        // Map middleware -> factories here
        'factories' => [
            'MB\AuthorizationMiddleware' => 'Foo\Factories\RestAuthorizationFactory',
        ],
        .
        .
        .
        'routes' : [
          [
              'name' => 'auth',
              'path' => "/auth/login/{login:\w+}/password/{password:\w+}",
              'middleware' => MB\AuthentificationMiddleware::class,
              'allowed_methods' => ['POST'],
          ],
        ]
        .
        .
```

### Step 3 - Create RestAuthorizationFactory 

Create RestAuthorizationFactory for injected IUserService

```
<?php
namespace Foo\Factories;

use Interop\Container\ContainerInterface;
use MB\AuthentificationMidleware;

/**
 * Description of RestAuthentificationFactory
 */
class RestAuthentificationFactory {
    
    public function __invoke(ContainerInterface $container)
    {
        return new AuthentificationMidleware( $container->get('IUserService') );
    }
}
```


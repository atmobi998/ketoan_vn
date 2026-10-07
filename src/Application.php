<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use App\Middleware\HostHeaderMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Event\EventManagerInterface;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\PasswordIdentifier;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;

use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

use Authorization\Policy\MapResolver;
use Authorization\Policy\ResolverCollection;
use Cake\Http\ServerRequest;
use App\Policy\RequestPolicy;

use Authorization\Policy\OrmResolver;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        // By default, does not allow fallback classes.
        FactoryLocator::add(
            'Table',
            (new TableLocator())->allowFallbackClass(false),
        );
        
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new HostHeaderMiddleware())
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthorizationMiddleware($this))
            ->add(new AuthenticationMiddleware($this));
            
            /*
            $csrf = new CsrfProtectionMiddleware([
                'httponly' => true,
            ]);
            $csrf->skipCheckCallback(function ($request) {
                return true;
            });
            $middlewareQueue->add($csrf);            
            */

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // Allow your Tables to be dependency injected
        //$container->delegate(new \Cake\ORM\Locator\TableContainer());
    }

    /**
     * Register custom event listeners here
     *
     * @param \Cake\Event\EventManagerInterface $eventManager
     * @return \Cake\Event\EventManagerInterface
     * @link https://book.cakephp.org/5/en/core-libraries/events.html#registering-listeners
     */
    public function events(EventManagerInterface $eventManager): EventManagerInterface
    {
        // $eventManager->on(new SomeCustomListenerClass());

        return $eventManager;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationService
    {
        $ormResolver = new OrmResolver();
        $mapResolver = new MapResolver();
        $mapResolver->map(ServerRequest::class, RequestPolicy::class);
        $resolverCollection = new ResolverCollection([$ormResolver, $mapResolver]);
        return new AuthorizationService($resolverCollection);
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {

        $path = $request->getUri()->getPath();

        $service = new AuthenticationService([
            'unauthenticatedRedirect' => '/login', 
            'queryParam' => 'redirect',
        ]);

        $fields = [
            'username' => 'username',
            'password' => 'password',
        ];

        $service->loadAuthenticator('Authentication.Session');

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/login',
            'identifier' => [
                'className' => 'Authentication.Password',
                'fields' => $fields,
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Users',
                    'finder' => 'authUser', 
                ],
                'passwordHasher' => [
                    'className' => 'Authentication.Fallback',
                    'hashers' => [
                        'Authentication.Default'
                    ]
                ]
            ]
        ]);

        $service->loadAuthenticator(\App\Authenticator\CookieAuthenticate::class, [
            'rememberMeField' => 'remember_me',
            'cookie' => [
                'name' => 'ketoanvnCookieAuth',
                'expires' => '+12 month',
            ],
            'identifier' => [
                'className' => 'Authentication.Password',
                'fields' => $fields,
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Users',
                    'finder' => 'authUser', 
                ]
            ]
        ]);

        if (\Cake\Core\Configure::read('AccessControl.multiColumn')) {
            $service->loadAuthenticator(\App\Authenticator\MultiColumnAuthenticate::class, [
                'fields' => $fields,
                'loginUrl' => '/login',
                'identifier' => [
                    'className' => 'Authentication.Password',
                    'fields' => $fields,
                    'resolver' => [
                        'className' => 'Authentication.Orm',
                        'userModel' => 'Users',
                        'finder' => 'authUser',
                    ]
                ]
            ]);
        }

        return $service;
        
    }

}

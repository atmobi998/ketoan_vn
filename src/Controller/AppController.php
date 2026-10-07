<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Authentication.Authentication');
        $this->Authorization->skipAuthorization();
        $this->loadComponent('FormProtection');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }
}

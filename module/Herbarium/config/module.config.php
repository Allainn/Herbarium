<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonLogin for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Herbarium;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Session\SessionManager;
use Herbarium\Model\UsuarioTable;
use Herbarium\Model\Usuario;
use Herbarium\Model\TipoUsuarioTable;
use Herbarium\Model\TipoUsuario;
use Herbarium\Model\ColetorTable;
use Herbarium\Model\Coletor;
use Herbarium\Model\ContinenteTable;
use Herbarium\Model\Continente;
use Herbarium\Model\PaisTable;
use Herbarium\Model\Pais;
use Herbarium\Model\EstadoTable;
use Herbarium\Model\Estado;
use Herbarium\Model\CidadeTable;
use Herbarium\Model\Cidade;
use Herbarium\Model\LocalidadeTable;
use Herbarium\Model\Localidade;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'herbarium' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/herbarium[/:controller[/:action[/:key[/:status]]]]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:controller]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'aliases' => [
            'autenticacao' => Controller\AutenticacaoController::class,
            'usuario' => Controller\UsuarioController::class,
            'coletor' => Controller\ColetorController::class,
            'herbarium' => Controller\IndexController::class,
        ],
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\LoginController::class => InvokableFactory::class,
            Controller\TipoUsuarioController::class => function($sm){
                $table = $sm->get(TipoUsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\TipoUsuarioController($table, $sessionManager);
            },
            Controller\ColetorController::class => function($sm){
                $table = $sm->get(ColetorTable::class);
                $sessionManager = new SessionManager();
                return new Controller\ColetorController($table, $sessionManager);
            },
            Controller\LocalidadeController::class => function($sm){
                $table = $sm->get(LocalidadeTable::class);
                $sessionManager = new SessionManager();
                return new Controller\LocalidadeController($table, $sessionManager);
            },
            Controller\AutenticacaoController::class => function($sm){
                $table = $sm->get(UsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\AutenticacaoController($table, $sessionManager);
            },
            Controller\UsuarioController::class => function($sm){
                $table = $sm->get(UsuarioTable::class);
                $parentTable = $sm->get(TipoUsuarioTable::class);
                $sessionManager = new SessionManager();
                return new Controller\UsuarioController($table, $parentTable, $sessionManager);
            },
            Controller\ContinenteController::class => function($sm){
                $table = $sm->get(ContinenteTable::class);
                $sessionManager = new SessionManager();
                return new Controller\ContinenteController($table, $sessionManager);
            },
            Controller\PaisController::class => function($sm){
                $table = $sm->get(PaisTable::class);
                $parentTable = $sm->get(ContinenteTable::class);
                $sessionManager = new SessionManager();
                return new Controller\PaisController($table, $parentTable, $sessionManager);
            },
            Controller\EstadoController::class => function($sm){
                $table = $sm->get(EstadoTable::class);
                $parentTable = $sm->get(PaisTable::class);
                $sessionManager = new SessionManager();
                return new Controller\EstadoController($table, $parentTable, $sessionManager);
            },
            Controller\CidadeController::class => function($sm){
                $table = $sm->get(CidadeTable::class);
                $parentTable = $sm->get(EstadoTable::class);
                $sessionManager = new SessionManager();
                return new Controller\CidadeController($table, $parentTable, $sessionManager);
            },
        ],
    ],
    'route_layouts' => [
        'herbarium'   => 'layout/user', 
        'home'        => 'layout/user', 
        'login'       => 'layout/login',
        'error/404'   => 'error/404',
        'error/index' => 'error/index',
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/user'             => __DIR__ . '/../view/layout/layout_user.phtml',
            'layout/login'            => __DIR__ . '/../view/layout/layout_login.phtml',
            'herbarium/index/index'   => __DIR__ . '/../view/herbarium/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'constraints' => [
        'action' => '[a-zA-Z0-9_-]+',
        'id' => '[0-9]+',
    ],
    'service_manager' => [
        'factories' => [
            UsuarioTable::class => function($sm) {
                $tableGateway = $sm->get('UsuarioTableGateway');
                $table = new UsuarioTable($tableGateway);
                return $table;
            },
            'UsuarioTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                return new TableGateway('tb_usuarios', $dbAdapter, null, $resultSetPrototype);
            },
            TipoUsuarioTable::class => function($sm) {
                $tableGateway = $sm->get('TipoUsuarioTableGateway');
                $table = new TipoUsuarioTable($tableGateway);
                return $table;
            },
            'TipoUsuarioTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new TipoUsuario());
                return new TableGateway('tb_tipo_usuarios', $dbAdapter, null, $resultSetPrototype);
            },
            ColetorTable::class => function($sm) {
                $tableGateway = $sm->get('ColetorTableGateway');
                $table = new ColetorTable($tableGateway);
                return $table;
            },
            'ColetorTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Coletor());
                return new TableGateway('tb_coletores', $dbAdapter, null, $resultSetPrototype);
            },
            ContinenteTable::class => function($sm) {
                $tableGateway = $sm->get('ContinenteTableGateway');
                $table = new ContinenteTable($tableGateway);
                return $table;
            },
            'ContinenteTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Continente());
                return new TableGateway('tb_continente', $dbAdapter, null, $resultSetPrototype);
            },
            PaisTable::class => function($sm) {
                $tableGateway = $sm->get('PaisTableGateway');
                $table = new PaisTable($tableGateway);
                return $table;
            },
            'PaisTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Pais());
                return new TableGateway('tb_pais', $dbAdapter, null, $resultSetPrototype);
            },
            EstadoTable::class => function($sm) {
                $tableGateway = $sm->get('EstadoTableGateway');
                $table = new EstadoTable($tableGateway);
                return $table;
            },
            'EstadoTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Estado());
                return new TableGateway('tb_estado', $dbAdapter, null, $resultSetPrototype);
            },
            CidadeTable::class => function($sm) {
                $tableGateway = $sm->get('CidadeTableGateway');
                $table = new CidadeTable($tableGateway);
                return $table;
            },
            'CidadeTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Cidade());
                return new TableGateway('tb_cidade', $dbAdapter, null, $resultSetPrototype);
            },
            LocalidadeTable::class => function($sm) {
                $tableGateway = $sm->get('LocalidadeTableGateway');
                $table = new LocalidadeTable($tableGateway);
                return $table;
            },
            'LocalidadeTableGateway' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Localidade());
                return new TableGateway('tb_localidade', $dbAdapter, null, $resultSetPrototype);
            },
        ]
    ]
];

<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Herbarium\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\Resources;
use Herbarium\Form\Usuario as UsuarioForm;
use Herbarium\Model\Usuario;
use Zend\Session\SessionManager;

class UsuarioController extends AbstractActionController
{
    private $table;
    private $parentTable;

    public function __construct($table, $parentTable, $sessionManager)
    {
        $this->table = $table;
        $this->parentTable = $parentTable;
        $sessionManager->start();
    }

    public function indexAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['logado']) && $_SESSION['logado'] == 'SIM'){
            return new ViewModel(
                ['models' => $this->table->fetchAll()]
            );
        }
        return $this->redirect()->toRoute(
            'login'
        );
    }

    /**
     * Action to add and change records
     */
    public function editAction()
    {
        $codigo = $this->params()->fromRoute('key', null);
        $usuario = $this->table->getModel($codigo);
        //print_r($usuario);
        $form = new UsuarioForm(
            'usuario',
            ['table' => $this->parentTable]
        );
        $form->get('submit')->setValue(
            empty($codigo) ? 'Cadastrar' : 'Alterar'
        );
        $sessionStorage = new SessionArrayStorage();
        if (isset($sessionStorage->model)){
            $usuario->exchangeArray($sessionStorage->model->toArray());
            unset($sessionStorage->model);
            $form->setInputFilter($usuario->getInputFilter());
            $this->initValidatorTranslator();
            $form->bind($usuario);
            $form->isValid();
        } else{
            $form->bind($usuario);
        }
        return [
            'form' => $form,
            'title' => empty($codigo) ? 'Incluir' : 'Alterar'
        ];
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = new UsuarioForm(
                'usuario',
                ['table' => $this->parentTable]
            );
            $usuario = new Usuario();
            $form->setInputFilter($usuario->getInputFilter());
            $post = $request->getPost();
            $form->setData($post);
            if (!$form->isValid()){
                $sessionStorage = new SessionArrayStorage();
                $sessionStorage->model = $post;
                return $this->redirect()->toRoute(
                    'herbarium',
                    [
                        'action'=>'edit',
                        'controller'=>'usuario'
                    ]
                );
            }
            $usuario->exchangeArray($form->getData());
            if(isset($usuario->id)){
                $usuario->id = 0;
            }
            $this->table->saveModel($usuario);
        }
        return $this->redirect()->toRoute(
            'herbarium',
            [
                'action'=>'edit',
                'controller'=>'usuario'
            ]
        );
    }

    /**
     * Action to remove records
     */
    public function deleteAction()
    {
        $codigo = $this->params()->fromRoute('key', null);
        $this->table->deleteModel($codigo);
        return $this->redirect()->toRoute(
            'herbarium',
            ['controller'=>'usuario']
        );
    }

    protected function initValidatorTranslator()
    {
        $translator = new Translator();
        $mvcTranslator = new MvcTranslator($translator);
        $mvcTranslator->addTranslationFilePattern(
            'phparray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        AbstractValidator::setDefaultTranslator($mvcTranslator);
    }
}

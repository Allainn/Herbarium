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
use Herbarium\Form\TipoUsuario as TipoUsuarioForm;
use Herbarium\Model\TipoUsuario;

class TipoUsuarioController extends AbstractActionController
{
    private $table;

    public function __construct($table, $sessionManager)
    {
        $this->table = $table;
        $sessionManager->start();
    }

    public function indexAction()
    {
        return new ViewModel(
            ['models' => $this->table->fetchAll()]
        );
    }

    /**
     * Action to add and change records
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('key', null);
        $tipoUsuario = $this->table->getModel($id);
        $form = new TipoUsuarioForm();
        $form->get('submit')->setValue(
            empty($id) ? 'Cadastrar' : 'Alterar'
        );
        $sessionStorage = new SessionArrayStorage();
        if (isset($sessionStorage->model)){
            $tipoUsuario->exchangeArray($sessionStorage->model->toArray());
            unset($sessionStorage->model);
            $form->setInputFilter($tipoUsuario->getInputFilter());
            $this->initValidatorTranslator();
        }
        $form->bind($tipoUsuario);
        $form->isValid();
        return [
            'form' => $form,
            'title' => empty($id) ? 'Incluir' : 'Alterar'
        ];
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = new TipoUsuarioForm();
            $tipoUsuario = new TipoUsuario();
            $form->setInputFilter($tipoUsuario->getInputFilter());
            $post = $request->getPost();
            $form->setData($post);
            if (!$form->isValid()){
                $sessionStorage = new SessionArrayStorage();
                $sessionStorage->model = $post;
                return $this->redirect()->toRoute(
                    'login',
                    [
                        'action'=>'edit',
                        'controller'=>'tipoUsuario'
                    ]
                );
            }
            $tipoUsuario->exchangeArray($form->getData());
            $this->table->saveModel($tipoUsuario);
        }
        return $this->redirect()->toRoute(
            'login',
            ['controller'=>'tipoUsuario']
        );
    }

    /**
     * Action to remove records
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('key', null);
        $this->table->deleteModel($id);
        return $this->redirect()->toRoute(
            'login',
            ['controller'=>'tipoUsuario']
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

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
use Herbarium\Form\Coleta as ColetaForm;
use Herbarium\Model\Coleta;
use Zend\Session\SessionManager;

class ColetaController extends AbstractActionController
{
    private $table;
    private $parentTableColetor;
    private $parentTableLocalidade;
    private $parentTableCidade;

    public function __construct($table, $parentTableColetor, $parentTableLocalidade, $parentTableCidade, $sessionManager)
    {
        $this->table = $table;
        $this->parentTableColetor = $parentTableColetor;
        $this->parentTableLocalidade = $parentTableLocalidade;
        $this->parentTableCidade = $parentTableCidade;
        $sessionManager->start();
    }

    public function indexAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            return new ViewModel(
                ['models' => $this->table->fetchAll()]
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/herbarium'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    /**
     * Action to add and change records
     */
    public function editAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $id = $this->params()->fromRoute('key', null);
            $coleta = $this->table->getModel($id);
            //print_r($coleta);
            $form = new ColetaForm(
                'coleta',
                [
                    'coletor' => $this->parentTableColetor,
                    'localidade' => $this->parentTableLocalidade,
                    'cidade' => $this->parentTableCidade
                ]
            );
            $form->get('submit')->setValue(
                empty($id) ? 'Cadastrar' : 'Alterar'
            );
            $sessionStorage = new SessionArrayStorage();
            if (isset($sessionStorage->model)){
                $coleta->exchangeArray($sessionStorage->model->toArray());
                unset($sessionStorage->model);
                $form->setInputFilter($coleta->getInputFilter());
                $this->initValidatorTranslator();
                $form->bind($coleta);
                $form->isValid();
            } else{
                $form->bind($coleta);
            }
            return [
                'form' => $form,
                'title' => empty($id) ? 'Incluir' : 'Alterar'
            ];
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/herbarium'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form = new ColetaForm(
                    'coleta',
                    [
                        'coletor' => $this->parentTableColetor,
                        'localidade' => $this->parentTableLocalidade,
                        'cidade' => $this->parentTableCidade
                    ]
                );
                $coleta = new Coleta();
                $form->setInputFilter($coleta->getInputFilter());
                $post = $request->getPost();
                $form->setData($post);
                if (!$form->isValid()){
                    $sessionStorage = new SessionArrayStorage();
                    $sessionStorage->model = $post;
                    return $this->redirect()->toRoute(
                        'herbarium',
                        [
                            'action'=>'edit',
                            'controller'=>'coleta'
                        ]
                    );
                }
                $coleta->exchangeArray($form->getData());
                $this->table->saveModel($coleta);
            }
            return $this->redirect()->toRoute(
                'herbarium',
                [
                    'action'=>'edit',
                    'controller'=>'coleta'
                ]
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/herbarium'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
    }

    public function ativarAction(){
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1){
            $id = $this->params()->fromRoute('key', null);
            $status = $this->params()->fromRoute('status', null);
            $coleta = $this->table->getModel($id);
            $coleta->status = (int) $status;
            $this->table->saveModel($coleta);
            return $this->redirect()->toRoute(
                'herbarium',
                ['controller'=>'coleta']
            );
        }
        else if(isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 2) {
            echo "<script>alert('Você não tem permissão de acessar está página!');</script>";
            echo "<script> document.location.href = '/herbarium'; </script>";
        }
        else {
            return $this->redirect()->toRoute(
                'login'
            );
        }
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

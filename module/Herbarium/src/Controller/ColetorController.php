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
use Herbarium\Form\Coletor as ColetorForm;
use Herbarium\Model\Coletor;
use Zend\Session\SessionManager;

class ColetorController extends AbstractActionController
{
    private $table;

    public function __construct($table, $sessionManager)
    {
        $this->table = $table;
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
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['logado']) && $_SESSION['logado'] == 'SIM'){
            $id = $this->params()->fromRoute('key', null);
            $coletor = $this->table->getModel($id);
            $form = new ColetorForm();
            $form->get('submit')->setValue(
                empty($id) ? 'Cadastrar' : 'Alterar'
            );
            $sessionStorage = new SessionArrayStorage();
            if (isset($sessionStorage->model)){
                $coletor->exchangeArray($sessionStorage->model->toArray());
                unset($sessionStorage->model);
                $form->setInputFilter($coletor->getInputFilter());
                $this->initValidatorTranslator();
            }
            $form->bind($coletor);
            $form->isValid();
            return [
                'form' => $form,
                'title' => empty($id) ? 'Incluir' : 'Alterar'
            ];
        }
        return $this->redirect()->toRoute(
            'login'
        );
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        if(isset($_SESSION['logado']) && $_SESSION['logado'] == 'SIM'){
            $request = $this->getRequest();
            if ($request->isPost()) {
                $form = new ColetorForm();
                $coletor = new Coletor();
                $form->setInputFilter($coletor->getInputFilter());
                $post = $request->getPost();
                $form->setData($post);
                if (!$form->isValid()){
                    $sessionStorage = new SessionArrayStorage();
                    $sessionStorage->model = $post;
                    return $this->redirect()->toRoute(
                        'herbarium',
                        [
                            'action'=>'edit',
                            'controller'=>'coletor'
                        ]
                    );
                }
                $coletor->exchangeArray($form->getData());
                $this->table->saveModel($coletor);
            }
            return $this->redirect()->toRoute(
                'herbarium',
                ['controller'=>'coletor']
            );
        }
        return $this->redirect()->toRoute(
            'login'
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

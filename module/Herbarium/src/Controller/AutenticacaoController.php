<?php 

namespace Herbarium\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\Resources;
use Herbarium\Model\Usuario;
use Herbarium\Model\TipoUsuario;

class AutenticacaoController extends AbstractActionController
{

    private $table;

    public function __construct($table, $sessionManager)
    {
        $this->table = $table;
        $sessionManager->start();

        $login = $_POST['login'];
        $senha = $_POST['senha'];
        
        $usuario = $this->table->getAutentication($login, $senha);
        $sessionStorage = new SessionArrayStorage();
        if (isset($sessionStorage->model)){
            $usuario->exchangeArray($sessionStorage->model->toArray());
            unset($sessionStorage->model);
        }
        if (isset($usuario->id)){
            $_SESSION['logado']= 'SIM'; 
            $_SESSION['login']= $login;
            $_SESSION['usuario']= $usuario->nome;
            $_SESSION['tipo_usuario']= $usuario->tipoUsuario->descricao;
            echo "<script>alert('Logado com Sucesso');</script>";
            echo "<script> document.location.href = '/herbarium'; </script>"; 
        }
        else
        {     
            echo "<script>alert('Prezado usuário,\\n Seus dados estão incorrentos');</script>";
            echo "<script> document.location.href = '/login'; </script>";    
        }

    }


    public function indexAction()
    {
        return new ViewModel(
            ['models' => $this->table->fetchAll()]
        );
    }

}
?>
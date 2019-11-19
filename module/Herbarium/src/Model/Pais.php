<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Pais
{
    /**
    * 
    * @var integer
    */
    public $id;
    
    /**
    * 
    * @var Continente
    */
    public $continente;
    
    /**
    * 
    * @var string
    */
    public $nome;

    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function __construct()
    {
        $this->continente = new Continente();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->continente->id = (isset($data['tb_continente_id'])) ? $data['tb_continente_id'] : null;
        $this->continente->nome = (isset($data['continente'])) ? $data['continente'] : null;
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'nome'=>$this->nome,
            'tb_continente_id'=>$this->continente->id
        ];
    }
}
?>
<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Cidade
{
    /**
    * 
    * @var integer
    */
    public $id;
    
    /**
    * 
    * @var Estado
    */
    public $estado;
    
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
        $this->estado = new Estado();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->estado->id = (isset($data['tb_estado_id'])) ? $data['tb_estado_id'] : null;
        $this->estado->nome = (isset($data['estado'])) ? $data['estado'] : null;
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'nome'=>$this->nome,
            'tb_estado_id'=>$this->estado->id
        ];
    }
}
?>
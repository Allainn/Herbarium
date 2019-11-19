<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Estado
{
    /**
    * 
    * @var integer
    */
    public $id;
    
    /**
    * 
    * @var Pais
    */
    public $pais;
    
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
        $this->pais = new Pais();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->pais->id = (isset($data['tb_pais_id'])) ? $data['tb_pais_id'] : null;
        $this->pais->nome = (isset($data['pais'])) ? $data['pais'] : null;
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'nome'=>$this->nome,
            'tb_pais_id'=>$this->pais->id
        ];
    }
}
?>
<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Continente
{
    /**
    * 
    * @var integer
    */
    public $id;
    
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

    public function exchangeArray($data)
    {
        foreach($data as $attribute => $value){
            $this->$attribute = $value;
        }
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'nome'=>$this->nome
        ];
    }
}
?>
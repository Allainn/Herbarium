<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Coletor
{
    /**
    * 
    * @var integer
    */
    public $id;
    
    public $nome_completo;
    public $nome_citacoes;

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
     * @return \Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new Factory();

            $inputFilter->add($factory->createInput([
                'name' => 'nome_completo',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 30
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'nome_citacoes',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 30
                        ]
                    ]
                ]
            ]));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'nome_completo'=>$this->nome_completo,
            'nome_citacoes'=>$this->nome_citacoes
        ];
    }
}
?>
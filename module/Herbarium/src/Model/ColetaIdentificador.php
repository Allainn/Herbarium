<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class ColetaIdentificador
{
    /**
    * 
    * @var integer
    */
    public $id;

    /**
    * 
    * @var Coletor
    */
    public $coletor;

    /**
    * 
    * @var Coleta
    */
    public $coleta;

    /**
    * 
    * @var integer
    */
    public $data_identificacao;


    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function __construct()
    {
        $this->coletor = new Coletor();
        $this->coleta = new Coleta();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->data_identificacao = (isset($data['data_identificacao'])) ? $data['data_identificacao'] : null;
        $this->coletor = new Coletor();
        $this->coletor->id = (isset($data['tb_coletores_id'])) ? $data['tb_coletores_id'] : null;
        $this->coletor->nome_citacoes = (isset($data['nome_citacoes'])) ? $data['nome_citacoes'] : null;
        $this->coleta = new Coleta();
        $this->coleta->id = (isset($data['tb_coletas_id'])) ? $data['tb_coletas_id'] : null;
        $this->coleta->catalago = (isset($data['tb_coletas_catalago'])) ? $data['tb_coletas_catalago'] : null;
    }


    // public function getInputFilter()
    // {
    //     if (! $this->inputFilter) {
    //         $inputFilter = new InputFilter();
    //         $factory = new InputFactory();
            

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'nome',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'StripTags'
    //                 ],
    //                 [
    //                     'name' => 'StringTrim'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'StringLength',
    //                     'options' => [
    //                         'encoding' => 'UTF-8',
    //                         'min' => 2,
    //                         'max' => 30
    //                     ]
    //                 ]
    //             ]
    //         ]));

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'sobrenome',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'StripTags'
    //                 ],
    //                 [
    //                     'name' => 'StringTrim'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'StringLength',
    //                     'options' => [
    //                         'encoding' => 'UTF-8',
    //                         'min' => 2,
    //                         'max' => 30
    //                     ]
    //                 ]
    //             ]
    //         ]));

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'login',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'StripTags'
    //                 ],
    //                 [
    //                     'name' => 'StringTrim'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'StringLength',
    //                     'options' => [
    //                         'encoding' => 'UTF-8',
    //                         'min' => 2,
    //                         'max' => 30
    //                     ]
    //                 ]
    //             ]
    //         ]));

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'senha',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'StripTags'
    //                 ],
    //                 [
    //                     'name' => 'StringTrim'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'StringLength',
    //                     'options' => [
    //                         'encoding' => 'UTF-8',
    //                         'min' => 2,
    //                         'max' => 30
    //                     ]
    //                 ]
    //             ]
    //         ]));


    //         $inputFilter->add($factory->createInput([
    //             'name' => 'link_lattes',
    //             'required' => false,
    //             'filters' => [
    //                 [
    //                     'name' => 'StripTags'
    //                 ],
    //                 [
    //                     'name' => 'StringTrim'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'StringLength',
    //                     'options' => [
    //                         'encoding' => 'UTF-8',
    //                         'min' => 2,
    //                         'max' => 30
    //                     ]
    //                 ]
    //             ]
    //         ]));

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'tb_tipo_usuarios_id',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'Int'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'Digits'
    //                 ]
    //             ]
    //         ]));

    //         $inputFilter->add($factory->createInput([
    //             'name' => 'status',
    //             'required' => true,
    //             'filters' => [
    //                 [
    //                     'name' => 'Int'
    //                 ]
    //             ],
    //             'validators' => [
    //                 [
    //                     'name' => 'Digits'
    //                 ]
    //             ]
    //         ]));


    //         $this->inputFilter = $inputFilter;
    //     }
    //     return $this->inputFilter;
    // }

    /**
     * 
     * @return array
     */
    public function getArrayCopy() {
        return [
            'id'=>$this->id,
            'data_identificacao'=>$this->data_identificacao,
            'tb_coletores_id'=>$this->coletor->id,
            'tb_coletas_id'=>$this->coleta->id,
            'tb_coletas_catalago'=>$this->coleta->catalago
        ];
    }
}
?>

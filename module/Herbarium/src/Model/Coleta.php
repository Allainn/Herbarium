<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Coleta
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
    public $catalogo;

    /**
    * 
    * @var Coletor
    */
    public $coletor;

    /**
    * 
    * @var integer
    */
    public $num_coleta;

    /**
    * 
    * @var string
    */
    public $comentarios;

    /**
    * 
    * @var string
    */
    public $data_coleta;

    /**
    * 
    * @var string
    */
    public $habitat;

    /**
    * 
    * @var Localidade
    */
    public $localidade;

    /**
    * 
    * @var Cidade
    */
    public $cidade;

    /**
    * 
    * @var string
    */
    public $plant_reino;

    /**
    * 
    * @var string
    */
    public $plant_filo;

    /**
    * 
    * @var string
    */
    public $plant_familia;

    /**
    * 
    * @var string
    */
    public $plant_genero;

    /**
    * 
    * @var bool
    */
    public $status;

    /**
     * 
     * @var array
     */
    public $coletas_identificadas;


    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function __construct()
    {
        $this->coletor = new Coletor();
        $this->localidade = new Localidade();
        $this->cidade = new Cidade();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->catalogo = (isset($data['catalogo'])) ? $data['catalogo'] : null;
        $this->num_coleta = (isset($data['num_coleta'])) ? $data['num_coleta'] : null;
        $this->comentarios = (isset($data['comentarios'])) ? $data['comentarios'] : null;
        $this->data_coleta = (isset($data['data_coleta'])) ? $data['data_coleta'] : null;
        $this->habitat = (isset($data['habitat'])) ? $data['habitat'] : null;
        $this->plant_reino = (isset($data['plant_reino'])) ? $data['plant_reino'] : null;
        $this->plant_filo = (isset($data['plant_filo'])) ? $data['plant_filo'] : null;
        $this->plant_familia = (isset($data['plant_familia'])) ? $data['plant_familia'] : null;
        $this->plant_genero = (isset($data['plant_genero'])) ? $data['plant_genero'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->coletor = new Coletor();
        $this->coletor->id = (isset($data['tb_coletores_id'])) ? $data['tb_coletores_id'] : null;
        $this->coletor->nome_citacoes = (isset($data['nome_citacoes'])) ? $data['nome_citacoes'] : null;
        $this->localidade = new Localidade();
        $this->localidade->id = (isset($data['tb_localidade_id'])) ? $data['tb_localidade_id'] : null;
        $this->localidade->local = (isset($data['local'])) ? $data['local'] : null;
        $this->localidade->desc_especifica = (isset($data['desc_especifica'])) ? $data['desc_especifica'] : null;
        $this->localidade->altitude = (isset($data['altitude'])) ? $data['altitude'] : null;
        $this->localidade->latitude = (isset($data['latitude'])) ? $data['latitude'] : null;
        $this->localidade->longitude = (isset($data['longitude'])) ? $data['longitude'] : null;
        $this->cidade = new Cidade();
        $this->cidade->id = (isset($data['tb_cidade_id'])) ? $data['tb_cidade_id'] : null;
        $this->cidade->nome = (isset($data['nome'])) ? $data['nome'] : null;
    }


    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput([
                'name' => 'tb_coletores_id',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]));
            

            $inputFilter->add($factory->createInput([
                'name' => 'catalogo',
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
                'name' => 'num_coleta',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'comentario',
                'required' => false,
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
                            'min' => 0,
                            'max' => 500
                        ]
                    ]
                ]
            ]));


            $inputFilter->add($factory->createInput([
                'name' => 'data_coleta',
                'required' => true
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'habitat',
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
                'name' => 'tb_cidade_id',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'local',
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
                'name' => 'desc_especifica',
                'required' => false,
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
                            'max' => 200
                        ]
                    ]
                ]
            ]));

            $inputFilter->add($factory->createInput([
                'name' => 'altitude',
                'required' => false,
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
                'name' => 'latitude',
                'required' => false,
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
                'name' => 'longitude',
                'required' => false,
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
                'name' => 'plant_reino',
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
                'name' => 'plant_filo',
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
                'name' => 'plant_familia',
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
                'name' => 'plant_genero',
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
                'name' => 'status',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
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
            'catalogo'=>$this->catalogo,
            'num_coleta'=>$this->num_coleta,
            'comentarios'=>$this->comentarios,
            'data_coleta'=>$this->data_coleta,
            'habitat'=>$this->habitat,
            'plant_reino'=>$this->plant_reino,
            'plant_filo'=>$this->plant_filo,
            'plant_familia'=>$this->plant_familia,
            'plant_genero'=>$this->plant_genero,
            'status'=>$this->status,
            'tb_coletores_id'=>$this->coletor->id,
            'tb_localidade_id'=>$this->localidade->id,
            'local'=>$this->localidade->local,
            'desc_local'=>$this->localidade->desc_especifica,
            'altitude'=>$this->localidade->altitude,
            'latitude'=>$this->localidade->latitude,
            'longitude'=>$this->localidade->longitude,
            'tb_cidade_id'=>$this->cidade->id
        ];
    }
}
?>

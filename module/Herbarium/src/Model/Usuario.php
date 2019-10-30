<?php
namespace Herbarium\Model;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Usuario
{
    /**
    * 
    * @var integer
    */
    public $id;

    /**
    * 
    * @var TipoUsuario
    */
    public $tipoUsuario;

    /**
    * 
    * @var string
    */
    public $nome;

    /**
    * 
    * @var string
    */
    public $sobrenome;

    /**
    * 
    * @var string
    */
    public $login;

    /**
    * 
    * @var string
    */
    public $senha;

    /**
    * 
    * @var string
    */
    public $linkLattes;

    /**
    * 
    * @var bool
    */
    public $status;


    /**
     * 
     * @var InputFilterInterface
     */
    private $inputFilter;

    public function __construct()
    {
        $this->tipoUsuario = new TipoUsuario();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->sobrenome = (isset($data['sobrenome'])) ? $data['sobrenome'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->senha = (isset($data['senha'])) ? $data['senha'] : null;
        $this->linkLattes = (isset($data['link_lattes'])) ? $data['link_lattes'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->tipoUsuario = new TipoUsuario();
        $this->tipoUsuario->id = (isset($data['tb_tipo_usuarios_id'])) ? $data['tb_tipo_usuarios_id'] : null;
        $this->tipoUsuario->descricao = (isset($data['descricao'])) ? $data['descricao'] : null;
    }


    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            

            $inputFilter->add($factory->createInput([
                'name' => 'nome',
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
                'name' => 'sobrenome',
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
                'name' => 'login',
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
                'name' => 'senha',
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
                'name' => 'link_lattes',
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
                'name' => 'tb_tipo_usuarios_id',
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
            'nome'=>$this->nome,
            'sobrenome'=>$this->sobrenome,
            'login'=>$this->login,
            'senha'=>$this->senha,
            'link_lattes'=>$this->linkLattes,
            'status'=>$this->status,
            'tb_tipo_usuario_id'=>$this->tipoUsuario->id
        ];
    }
}
?>

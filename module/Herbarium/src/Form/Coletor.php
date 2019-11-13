<?php
    namespace Herbarium\Form;

    use Zend\Form\Form;

    class Coletor extends Form
    {
        public function __construct($name = null)
        {
            parent::__construct('coletor');
            $this->setAttribute('method', 'post');

            $this->add([
                'name' => 'id',
                'type' => 'hidden'
            ]);    
            $this->add(array(
                'name' => 'nome_completo',
                'attributes' => array(
                    'type' => 'text',
                    'autofocus' => 'autofocus'
                ),
                'options' => array(
                    'label' => 'Nome Completo: ',
                ),
            ));
            $this->add(array(
                'name' => 'nome_citacoes',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Nome Citação: ',
                ),
            ));
            $this->add([
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => 'Gravar',
                    'id' => 'submitbutton',
                ],
            ]);
        }
    }
?>
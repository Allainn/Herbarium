<?php
    namespace Herbarium\Form;

    use Zend\Form\Form;
    use Herbarium\Model\TipoUsuarioTable;

    class Usuario extends Form
    {
        private $table;

        public function __construct($name = null, array $options = array())
        {
            if (isset($options['table'])){
                $this->table = $options['table'];
            } else {
                throw new \Exception('Form requires TipoUsuarioTable instance');
            }
            parent::__construct('usuario');
            $this->setAttribute('method', 'post');
            $this->add(array(
                'name' => 'id',
                'type' => 'hidden'
            ));
            $this->add(array(
                'name' => 'nome',
                'attributes' => array(
                    'type' => 'text',
                    'autofocus' => 'autofocus'
                ),
                'options' => array(
                    'label' => 'Nome: ',
                ),
            ));
            $this->add(array(
                'name' => 'sobrenome',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Sobrenome: ',
                ),
            ));
            $this->add(array(
                'name' => 'login',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Login: ',
                ),
            ));
            $this->add(array(
                'name' => 'senha',
                'attributes' => array(
                    'type' => 'password'
                ),
                'options' => array(
                    'label' => 'Senha: ',
                ),
            ));

            $this->add(array(
                'name' => 'link_lattes',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Perfil lattes: ',
                ),
            ));
            $this->add(array(
                'name' => 'tb_tipo_usuarios_id',
                'type' => 'select',
                'options' => array(
                    'label' => 'Tipo Usuario: ',
                    'value_options' => $this->getValueOptions()
                ),
            ));
            $this->add(array(
                'name' => 'status',
                'type' => 'checkbox',
                'options' => array(
                    'label' => 'Status Ativo: ',
                    'checked_value' => 1,
                    'unchecked_value' => 0,
                ),
                'attributes' => [
                    'value' => 'Ativo',
               ],
            ));
            $this->add(array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Gravar',
                    'id' => 'submitbutton',
                ),
            ));
        }

        /**
         * 
         * @return TipoUsuarioTable
         */
        private function getTipoUsuarioTable()
        {
            return $this->table;
        }

        /**
         * 
         * @return Generator
         */
        private function getValueOptions()
        {
            $valueOptions = array();
            $tiposusuarios = $this->getTipoUsuarioTable()->fetchAll();
            $options = array();
            foreach ($tiposusuarios as $tipousuario) {
                $options[$tipousuario->id] = $tipousuario->descricao;
            }
            return $options;
        }
    }
?>
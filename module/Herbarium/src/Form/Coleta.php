<?php
    namespace Herbarium\Form;

    use Zend\Form\Form;
    use Herbarium\Model\ColetorTable;
    use Herbarium\Model\LocalidadeTable;
    use Herbarium\Model\ContinenteTable;
    use Herbarium\Model\PaisTable;
    use Herbarium\Model\EstadoTable;
    use Herbarium\Model\CidadeTable;

    class Coleta extends Form
    {
        private $table_coletor;
        private $table_localidade;
        private $table_continente;
        private $table_pais;
        private $table_estado;
        private $table_cidade;

        public function __construct($name = null, array $options = array())
        {
            if (isset($options['coletor'])){
                $this->table_coletor = $options['coletor'];
            } else {
                throw new \Exception('Form requires Coletor instance');
            }

            if (isset($options['localidade'])){
                $this->table_localidade = $options['localidade'];
            } else {
                throw new \Exception('Form requires Localidade instance');
            }

            // if (isset($options['continente'])){
            //     $this->table = $options['continente'];
            // } else {
            //     throw new \Exception('Form requires Continente instance');
            // }

            // if (isset($options['pais'])){
            //     $this->table = $options['pais'];
            // } else {
            //     throw new \Exception('Form requires Pais instance');
            // }

            // if (isset($options['estado'])){
            //     $this->table = $options['estado'];
            // } else {
            //     throw new \Exception('Form requires Estado instance');
            // }

            if (isset($options['cidade'])){
                $this->table_cidade = $options['cidade'];
            } else {
                throw new \Exception('Form requires Cidade instance');
            }

            parent::__construct('coleta');
            $this->setAttribute('method', 'post');
            $this->add(array(
                'name' => 'id',
                'type' => 'hidden'
            ));
            $this->add(array(
                'name' => 'tb_coletores_id',
                'type' => 'select',
                'autofocus' => 'autofocus',
                'options' => array(
                    'label' => 'Coletor: ',
                    'value_options' => $this->getValueOptions('coletor')
                ),
            ));
            $this->add(array(
                'name' => 'catalogo',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array(
                    'label' => 'Catálogo: ',
                ),
            ));
            $this->add(array(
                'name' => 'num_coleta',
                'attributes' => array(
                    'type' => 'number'
                ),
                'options' => array(
                    'label' => 'Número da Coleta: ',
                ),
            ));
            $this->add(array(
                'name' => 'comentarios',
                'attributes' => array(
                    'type' => 'textarea'
                ),
                'options' => array(
                    'label' => 'Comentários: ',
                ),
            ));
            $this->add(array(
                'name' => 'data_coleta',
                'attributes' => array(
                    'type' => 'date'
                ),
                'options' => array(
                    'label' => 'Data Coleta: ',
                ),
            ));

            $this->add(array(
                'name' => 'habitat',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Habitat: ',
                ),
            ));
            $this->add(array(
                'name' => 'tb_cidade_id',
                'type' => 'select',
                'options' => array(
                    'label' => 'Cidade: ',
                    'value_options' => $this->getValueOptions('cidade')
                ),
            ));
            $this->add(array(
                'name' => 'local',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Local: ',
                ),
            ));
            $this->add(array(
                'name' => 'desc_especifica',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Descrição Local: ',
                ),
            ));
            $this->add(array(
                'name' => 'altitude',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Altitude: ',
                ),
            ));
            $this->add(array(
                'name' => 'latitude',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Latitude: ',
                ),
            ));
            $this->add(array(
                'name' => 'longitude',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Longitude: ',
                ),
            ));
            $this->add(array(
                'name' => 'plant_reino',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Reino: ',
                ),
            ));
            $this->add(array(
                'name' => 'plant_filo',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Filo: ',
                ),
            ));
            $this->add(array(
                'name' => 'plant_familia',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Familia: ',
                ),
            ));
            $this->add(array(
                'name' => 'plant_genero',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Gênero: ',
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
         * @return ColetorTable
         */
        private function getColetorTable()
        {
            return $this->table_coletor;
        }

        /**
         * 
         * @return CidadeTable
         */
        private function getCidadeTable()
        {
            return $this->table_cidade;
        }


        /**
         * 
         * @return Generator
         */
        private function getValueOptions($tipo)
        {
            $valueOptions = array();
            $options = array();
            if($tipo == 'coletor') {
                $coletores = $this->getColetorTable()->fetchAll();
                $options = array();
                foreach ($coletores as $coletor) {
                    $options[$coletor->id] = $coletor->nome_citacoes;
                }
            }
            elseif($tipo == 'cidade') {
                $cidades = $this->getCidadeTable()->fetchAll();
                $options = array();
                foreach ($cidades as $cidade) {
                    $options[$cidade->id] = $cidade->nome;
                }
            }
            return $options;
        }
    }
?>
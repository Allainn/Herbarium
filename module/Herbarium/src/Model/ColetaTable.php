<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class ColetaTable
    {
        /**
         * 
         * @var TableGatewayInterface
         */
        private $tableGateway;

        /**
         * 
         * @var TableGatewayInterface
         */
        private $tableGatewayLocalidade;

        /**
         * 
         * @var string
         */
        private $keyName = 'id';

        /**
         * 
         * @param TableGatewayInterface $tableGateway
         */
        public function __construct(TableGatewayInterface $tableGateway, TableGatewayInterface $tableGatewayLocalidade)
        {
            $this->tableGateway = $tableGateway;
            $this->tableGatewayLocalidade = $tableGatewayLocalidade;
        }

        /**
         * 
         * @return ResultInterface
         */
        public function fetchAll()
        {
            $select = new Select();
            $select->from('tb_coletas')
                ->columns(array('id', 'catalogo', 'num_coleta', 'comentarios', 'data_coleta', 'habitat', 'plant_reino',
                'plant_filo','plant_familia', 'plant_genero', 'status', 'tb_coletores_id','tb_localidade_id','tb_cidade_id'))
                ->join(array('coletor'=>'tb_coletores'),'tb_coletas.tb_coletores_id = coletor.id', 'nome_citacoes')
                ->join(array('localidade'=>'tb_localidade'),'tb_coletas.tb_localidade_id = localidade.id', array('local','desc_especifica', 'altitude', 'latitude', 'longitude'))
                ->join(array('cidade'=>'tb_cidade'),'tb_coletas.tb_cidade_id = cidade.id', 'nome');
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }


        /**
         * 
         * @param string $keyValue
         * @return Coleta
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_coletas')
                ->columns(array('id', 'catalogo', 'num_coleta', 'comentarios', 'data_coleta', 'habitat', 'plant_reino',
                'plant_filo','plant_familia', 'plant_genero', 'status', 'tb_coletores_id','tb_localidade_id','tb_cidade_id'))
                ->join(array('coletor'=>'tb_coletores'),'tb_coletas.tb_coletores_id = coletor.id', 'nome_citacoes')
                ->join(array('localidade'=>'tb_localidade'),'tb_coletas.tb_localidade_id = localidade.id', array('local','desc_especifica', 'altitude', 'latitude', 'longitude'))
                ->join(array('cidade'=>'tb_cidade'),'tb_coletas.tb_cidade_id = cidade.id', 'nome')
                ->where(array('tb_coletas.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Coleta();
            }

            return $row;
        }

        /**
         * 
         * @param Coleta $coleta
         */
        public function saveModel(Coleta $coleta)
        {
            $data = array(
                'catalogo'=>$coleta->catalogo,
                'num_coleta'=>$coleta->num_coleta,
                'comentarios'=>$coleta->comentarios,
                'data_coleta'=>$coleta->data_coleta,
                'habitat'=>$coleta->habitat,
                'plant_reino'=>$coleta->plant_reino,
                'plant_filo'=>$coleta->plant_filo,
                'plant_familia'=>$coleta->plant_familia,
                'plant_genero'=>$coleta->plant_genero,
                'status'=>$coleta->status,
                'tb_coletores_id'=>$coleta->coletor->id,
                'tb_localidade_id'=>$coleta->localidade->id,
                'tb_cidade_id'=>$coleta->cidade->id
            );
            $dataLocalidade = array(
                'local'=>$coleta->localidade->local,
                'desc_especifica'=>$coleta->localidade->desc_especifica,
                'altitude'=>$coleta->localidade->altitude,
                'latitude'=>$coleta->localidade->latitude,
                'longitude'=>$coleta->localidade->longitude
            );
            $id = $coleta->id;
            $idlocal = $coleta->localidade->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = $id;
                $dataLocalidade['id'] = $idlocal;
                $idlocal = $this->tableGatewayLocalidade->insert($dataLocalidade);
                $data['tb_localidade_id'] = $idlocal;
                $this->tableGateway->insert($data);

            } else {
                $dataLocalidade['id'] = $idlocal;
                $idlocal = $this->tableGatewayLocalidade->insert($dataLocalidade);
                $data['tb_localidade_id'] = $idlocal;
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
    }
?>

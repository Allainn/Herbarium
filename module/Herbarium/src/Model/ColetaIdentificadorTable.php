<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class ColetaIdentificadorTable
    {
        /**
         * 
         * @var TableGatewayInterface
         */
        private $tableGateway;

        /**
         * 
         * @var string
         */
        private $keyName = 'id';

        /**
         * 
         * @param TableGatewayInterface $tableGateway
         */
        public function __construct(TableGatewayInterface $tableGateway)
        {
            $this->tableGateway = $tableGateway;
        }

        /**
         * 
         * @return ResultInterface
         */
        public function fetchAll()
        {
            $select = new Select();
            $select->from('tb_coletas_identificadores')
                ->columns(array('id', 'data_identificacao','tb_coletores_id', 'tb_coletas_id'))
                ->join(array('coletor'=>'tb_coletores'),'tb_coletas_identificadores.tb_coletor_id = coletor.id', 'nome_citacoes')
                ->join(array('coleta'=>'tb_coleta'),'tb_coletas_identificadores.tb_coleta_id = coleta.id', 'tb_coletas_catalago');
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return ColetaIdentificador
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_coletas_identificadores')
                ->columns(array('id', 'data_identificacao','tb_coletores_id', 'tb_coletas_id'))
                ->join(array('coletor'=>'tb_coletores'),'tb_coletas_identificadores.tb_coletor_id = coletor.id', 'nome_citacoes')
                ->join(array('coleta'=>'tb_coleta'),'tb_coletas_identificadores.tb_coleta_id = coleta.id', 'tb_coletas_catalago')
                ->where(array('tb_coletas_identificadores.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new ColetaIdentificador();
            }

            return $row;
        }

        /**
         * 
         * @param ColetaIdentificador $coletaIdentificador
         */
        public function saveModel(ColetaIdentificador $coletaIdentificador)
        {
            $data = array(
                'data_identificacao' => $coletaIdentificador->nome,
                'tb_coletores_id' => $coletaIdentificador->coletor->id,
                'tb_coletas_id'=>$coletaIdentificador->coleta->id,
            );
            $id = $coletaIdentificador->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = $id;
                $this->tableGateway->insert($data);
            } else {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
    }
?>

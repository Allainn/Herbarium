<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;

    class ColetorTable
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
            $resultSet = $this->tableGateway->select();
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return Coletor
         */
        public function getModel($keyValue)
        {
            $rowset = $this->tableGateway->select(array($this->keyName => $keyValue));
            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Coletor();
            }

            return $row;
        }

        /**
         * 
         * @param Coletor $coletor
         */
        public function saveModel(Coletor $coletor)
        {
            $data = array(
                'nome_completo' => $coletor->nome_completo,
                'nome_citacoes' => $coletor->nome_citacoes
            );
            $id = $coletor->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = 0;
                $this->tableGateway->insert($data);
            } else {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
    }
?>
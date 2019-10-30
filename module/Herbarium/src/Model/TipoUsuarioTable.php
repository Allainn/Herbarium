<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;

    class TipoUsuarioTable
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
         * @return TipoUsuario
         */
        public function getModel($keyValue)
        {
            $rowset = $this->tableGateway->select(array($this->keyName => $keyValue));
            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new TipoUsuario();
            }

            return $row;
        }

        /**
         * 
         * @param TipoUsuario $tipoUsuario
         */
        public function saveModel(TipoUsuario $tipoUsuario)
        {
            $data = array(
                'descricao' => $tipoUsuario->descricao
            );
            $id = $tipoUsuario->id;
            if (empty($this->getModel($id)->id)) {
                $data['id'] = $id;
                $this->tableGateway->insert($data);
            } else {
                $this->tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }

        /**
         * 
         * @param mixed $keyValue
         */
        public function deleteModel($keyValue)
        {
            $this->tableGateway->delete(array(
                $this->keyName => $keyValue
            ));
        }
    }
?>
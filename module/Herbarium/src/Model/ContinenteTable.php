<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;

    class ContinenteTable
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
         * @return Continente
         */
        public function getModel($keyValue)
        {
            $rowset = $this->tableGateway->select(array($this->keyName => $keyValue));
            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Continente();
            }

            return $row;
        }
    }
?>
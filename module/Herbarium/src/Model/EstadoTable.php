<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class EstadoTable
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
            $select->from('tb_estado')
                ->columns(array('id', 'tb_pais_id', 'nome'))
                ->join(array('c'=>'tb_pais'),'tb_estado.tb_pais_id = c.id', array('pais' => 'nome'));
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return Estado
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_estado')
                ->columns(array('id', 'tb_pais_id', 'nome'))
                ->join(array('c'=>'tb_pais'),'tb_estado.tb_pais_id = c.id', array('pais' => 'nome'))
                ->where(array('tb_estado.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Estado();
            }

            return $row;
        }

    }
?>

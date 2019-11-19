<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class CidadeTable
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
            $select->from('tb_cidade')
                ->columns(array('id', 'tb_estado_id', 'nome'))
                ->join(array('c'=>'tb_estado'),'tb_cidade.tb_estado_id = c.id', array('estado' => 'nome'));
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return Cidade
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_cidade')
                ->columns(array('id', 'tb_estado_id', 'nome'))
                ->join(array('c'=>'tb_estado'),'tb_cidade.tb_estado_id = c.id', array('estado' => 'nome'))
                ->where(array('tb_cidade.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Cidade();
            }

            return $row;
        }

    }
?>

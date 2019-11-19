<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class PaisTable
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
            $select->from('tb_pais')
                ->columns(array('id', 'tb_continente_id', 'nome'))
                ->join(array('c'=>'tb_continente'),'tb_pais.tb_continente_id = c.id', array('continente' => 'nome'));
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        /**
         * 
         * @param string $keyValue
         * @return Pais
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_pais')
                ->columns(array('id', 'tb_continente_id', 'nome'))
                ->join(array('c'=>'tb_continente'),'tb_pais.tb_continente_id = c.id', array('continente' => 'nome'))
                ->where(array('tb_pais.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Pais();
            }

            return $row;
        }

    }
?>

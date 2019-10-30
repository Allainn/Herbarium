<?php
    namespace Herbarium\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;
    use Zend\Db\Adapter\Driver\ResultInterface;
    use Zend\Db\Sql\Select;

    class UsuarioTable
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
            $select->from('tb_usuarios')
                ->columns(array('id', 'tb_tipo_usuarios_id', 'nome', 'sobrenome', 'login', 'link_lattes', 'status'))
                ->join(array('tuser'=>'tb_tipo_usuarios'),'tb_usuarios.tb_tipo_usuarios_id = tuser.id', 'descricao');
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        /**
         * 
         * @param string $login
         * @param string $senha
         * @return Usuario
         */
        public function getAutentication($login, $senha)
        {
            $select = new Select();
            $select->from('tb_usuarios')
                ->columns(array('id', 'tb_tipo_usuarios_id', 'nome', 'sobrenome', 'login', 'senha', 'link_lattes', 'status'))
                ->join(array('tuser'=>'tb_tipo_usuarios'),'tb_usuarios.tb_tipo_usuarios_id = tuser.id', 'descricao')
                ->where(array('tb_usuarios.login' => $login))
                ->where(array('tb_usuarios.senha' => $senha));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Usuario();
            }

            return $row;
        }


        /**
         * 
         * @param string $keyValue
         * @return Usuario
         */
        public function getModel($keyValue)
        {
            $select = new Select();
            $select->from('tb_usuarios')
                ->columns(array('id', 'tb_tipo_usuarios_id', 'nome', 'sobrenome', 'login', 'senha', 'link_lattes', 'status'))
                ->join(array('tuser'=>'tb_tipo_usuarios'),'tb_usuarios.tb_tipo_usuarios_id = tuser.id', 'descricao')
                ->where(array('tb_usuarios.id' => $keyValue));
            $rowset = $this->tableGateway->selectWith($select);

            if ($rowset->count()>0){
                $row = $rowset->current();
            } else {
                $row = new Usuario();
            }

            return $row;
        }

        /**
         * 
         * @param Usuario $usuario
         */
        public function saveModel(Usuario $usuario)
        {
            $data = array(
                'nome' => $usuario->nome,
                'tb_tipo_usuarios_id' => $usuario->tipoUsuario->id,
                'sobrenome'=>$usuario->sobrenome,
                'login'=>$usuario->login,
                'senha'=>$usuario->senha,
                'link_lattes'=>$usuario->linkLattes,
                'status'=>$usuario->status
            );
            $id = $usuario->id;
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

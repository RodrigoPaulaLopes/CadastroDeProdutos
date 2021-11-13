<?php
    require_once "./banco.php";
    require_once "./Produto.php";
    class ProdutoDao extends Conexao{
        


        public function mostrarTodos(){
            try{

                $stm = $this->conn->query('SELECT * FROM produto ORDER BY nome');
                $rs = $stm->fetchall(PDO::FETCH_ASSOC);
                $produtos = [];
    
                foreach($rs as $produto){
                    array_push($produtos, $produto);
                }
    
                return $produtos;
            }catch(PDOException $e){
                echo "Erro no banco: ".$e->getMessage();
            }

        }

        public function inserir(Produto $p){

                $stm = $this->conn->prepare('SELECT id FROM produto WHERE nome = :nome');
                $stm->bindParam(':nome', $p->nome);
                $stm->execute();
                if($stm->rowCount() > 0){
                    return false;
                }else{
                    $stm = $this->conn->prepare("INSERT INTO produto 
                    (nome, descricao, preco, quantidade, data) VALUES ( :nome, :descricao, :preco, :quantidade, :d)");
                    $stm->bindParam(':nome', $p->nome);    
                    $stm->bindParam(':descricao', $p->descricao);   
                    $stm->bindParam(':preco', $p->preco); 
                    $stm->bindParam(':quantidade', $p->quantidade);
                    $stm->bindParam(':d', $p->data);
                    $stm->execute();
                    return true;
                }

                
           
        } 

        public function deletar($id){
            $stm = $this->conn->prepare('DELETE FROM produto WHERE id = :id');
            $stm->bindParam(':id', $id);
            $stm->execute();
        }

        public function mostrarProduto($id){
            $stm = $this->conn->prepare('SELECT * FROM produto WHERE id = :id');
            $stm->bindParam(':id', $id);
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        }
        public function atualizar(Produto $p, $id){
            $stm = $this->conn->prepare("UPDATE produto SET nome = :nome,
            descricao = :descricao,
            preco = :preco,
            quantidade = :quantidade, data = :d WHERE id = :id");

            $stm->bindParam(':nome', $p->nome);
            $stm->bindParam(':descricao', $p->descricao);
            $stm->bindParam(':preco', $p->preco);
            $stm->bindParam(':quantidade', $p->quantidade);
            $stm->bindParam(':d', $p->data);
            $stm->bindParam(':id', $id);
            return $stm->execute();
        }
    }

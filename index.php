<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Crud</title>
</head>
<?php
require "./Produto.php";
require "./ProdutoDao.php";
$mensagem = "";

//Insere os dados no banco
if (isset($_POST['nome'])) {

    if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {


        //atualizar dados dados

        if (isset($_GET['id_up'])) {
            $id = addslashes($_GET['id_up']);
            $p = new Produto();

            $p->nome = addslashes($_POST['nome']);
            $p->descricao = addslashes($_POST['descricao']);
            $p->preco = addslashes($_POST['preco']);
            $p->quantidade = addslashes($_POST['quantidade']);
            $p->data = addslashes($_POST['data']);

            if (!empty($p->nome) && !empty($p->descricao) && !empty($p->preco) && !empty($p->quantidade) && !empty($p->data)) {
                $dao = new ProdutoDao();
                if (!$dao->atualizar($p, $id)) {
                    $mensagem = "Dados já cadastrados";
                };
                header("location: index.php");
            } else {
                $mensagem = "preencha todos os campos!";
            }
        }
    }
    //cadastra um novo produto.
    else {
        $p = new Produto();

        $p->nome = addslashes($_POST['nome']);
        $p->descricao = addslashes($_POST['descricao']);
        $p->preco = addslashes($_POST['preco']);
        $p->quantidade = addslashes($_POST['quantidade']);
        $p->data = addslashes($_POST['data']);

        if (!empty($p->nome) && !empty($p->descricao) && !empty($p->preco) && !empty($p->quantidade) && !empty($p->data)) {
            $dao = new ProdutoDao();
            if (!$dao->inserir($p)) {
                $mensagem = "Dados já cadastrados";
            };
        } else {
            $mensagem = "preencha todos os campos!";
        }
    }
}
//delete os dados do banco
if (isset($_GET['id'])) {
    $dao = new ProdutoDao();
    $id = $_GET['id'];
    $dao->deletar($id);
    header("location: index.php");
}
//pega todos os dados da tabela produto no banco de dados e retorna eles em array.
$dao = new ProdutoDao();
$produtos = $dao->mostrarTodos();


//mostar somente um produtos
if (isset($_GET['id_up'])) {
    $id_up = $_GET['id_up'];
    $p = new ProdutoDao();
    $unicoProduto = $p->mostrarProduto($id_up);
}




?>

<body>

    <div class="container">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Produto</label>
                <input value="<?php if (isset($unicoProduto)) echo $unicoProduto['nome'] ?>" type="text" name="nome" class="form-control" id="nome" placeholder="Digite o nome do produto." required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="3" required><?php if (isset($unicoProduto)) echo $unicoProduto['descricao'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Quantidade</label>
                <input value="<?php if (isset($unicoProduto)) echo $unicoProduto['quantidade'] ?>" type="number" name="quantidade" min=1 max=100 class="form-control" id="nome" placeholder="Digite a quantidade" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Preço</label>
                <input value="<?php if (isset($unicoProduto)) echo $unicoProduto['preco'] ?>" type="text" name="preco" class="form-control" id="nome" placeholder="Digite a quantidade" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Data</label>
                <input value="<?php if (isset($unicoProduto)) echo $unicoProduto['data'] ?>" type="Date" name="data" class="form-control" id="nome" required>
            </div>
            <input type="submit" name="inserir" class="btn btn-primary" value="<?= (isset($unicoProduto)) ? "Atualizar" : "Cadastrar" ?>">
        </form>
    </div>

    <div class="container">
        <div class="mt-3 alert alert-primary" role="alert">
            <?= $mensagem ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Data</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto) : ?>
                    <tr>
                        <th scope="row"><?= $produto['id'] ?></th>
                        <td><?= $produto['nome'] ?></td>
                        <td><?= $produto['descricao'] ?></td>
                        <td>R$ <?= $produto['preco'] ?></td>
                        <td><?= $produto['quantidade'] ?></td>
                        <td><?= $produto['data'] ?></td>
                        <td>
                            <a href="index.php?id_up=<?= $produto['id'] ?>" class="btn btn-success">Editar</a>
                            <a href="index.php?id=<?= $produto['id'] ?>" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
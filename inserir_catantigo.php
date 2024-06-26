<?php
// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])){
    header('Location:login.php');
}
?>
<?php
require_once("conexao.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $escolha_produto= $_POST['escolha_produto'];
    $escolha_fornecedor= $_POST['escolha_fornecedor'];

    try{
        $sql= $pdo->query("INSERT INTO categorias (id_produto, id_fornecedor) VALUES ('$escolha_produto', '$escolha_fornecedor')");

        echo "<script>window.alert('Dados registrados com sucesso')</script>";

        header('location:index.php?pagina=categorias');

    }catch(Exception $e){
        echo "Erro ao cadastrar" .$e;
    }

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de categoria</title>
    <style>
    h2{
        color: white;
        text-align: center;
        margin-bottom: 30px;
    }
    input, select{
        width: 100%;
        padding: 8px;
        font-size: 15px;
        font-weight: bold;
        box-sizing: border-box;
        border: 1px solid #ccc;
        margin-top: 8px;
        background-color: white;
        color: black;
    }
    label{
        display: block;
        color: white;
        font-weight: bold;
        margin: 5px 0 5px;
        font-size: 20px;
    }
    button:hover{
        background-color: #45a049;
    }    
     </style>
</head>
<body>
<?php if(!isset($_GET['editar'])){?>
        <form class="inserir" action="" method="post">
            <h2>Inserir novo fornecedor</h2>
            <label for="">Produto</label>
            <select name="escolha_produto" required>
                <option value="produto">Selecione um produto</option>
                <?php 
                #recuperar o nome do produto da tabela produtos
                $resultados= $sql_produtos->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $linhas){
                    echo '<option value=" '.$linhas['id_produto'].' ">'.$linhas['nome_produto']. '</option>';
                }
                ?>
            </select>
            <label for="">Nome do fornecedor</label>
            <select name="escolha_fornecedor" required>
                <option value="produto">Selecione um produto</option>
                <?php 
                #recuperar o nome do produto da tabela produtos
                $resultados= $sql_fornecedores->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $linhas){
                    echo '<option value=" '.$linhas['id_fornecedor'].' ">'.$linhas['nome_fornecedor']. '</option>';
                }
                ?>
            </select>
            <button class="button" type="submit">Cadastrar</button>
        </form>
    <?php
    }else {
        $id_fornecedor_produto= $_GET['editar'];
        $sql_categorias= $pdo->query("SELECT * FROM categorias WHERE id_fornecedor_produto= $id_fornecedor_produto");
        $linhas= $sql_categorias->fetch(PDO::FETCH_ASSOC);
    ?>
        <form class="inserir" action="editar_fornecedor.php" method="post">
            <h2>Editar categoria</h2>
            <input type="hidden" name="id_fornecedor_produto" value="<?php echo $linhas['id_fornecedor_produto']; ?>">
            <label for="">Produto</label>
            <select name="escolha_produto" required value="<?php echo '<option value=" '.$linhas['id_produto'].' ">'.$linhas['nome_produto']. '</option>'; ?>">
            </select>
            <label for="">Nome do fornecedor</label>
            <select name="escolha_fornecedor" required value="<?php echo '<option value=" '.$linhas['id_fornecedor'].' ">'.$linhas['nome_fornecedor']. '</option>'; ?>">
            </select>
            <button class="button" type="submit">Cadastrar</button>
        </form>
    <?php } ?>
</body>
</html>